<?php

echo '<pre>';
//ini_set('error_reporting', E_ALL);

session_start();
ini_set('max_execution_time', 5 * 60); //300 seconds = 5 minutes
ini_set('memory_limit', '999M');

require_once('../conn.php');
require_once("lib/ImapMailbox.php");

//define web url;
define('BASE_URL', 'HTTPS://'.$_SERVER['HTTP_HOST']);
define('THEME_URL', BASE_URL.'/public');
define('BASE_PATH', '/var/www/html/karmora.com');

define('APPMODE', 'test');
/*
 * test credentials 
 */
define('GMAIL_EMAIL', 'shopkarmora@gmail.com');
define('GMAIL_PASSWORD', 'karmora7667');

/*
 * live credentials
 */
/*
  define('GMAIL_EMAIL', 'shopkarmora@gmail.com');
  define('GMAIL_PASSWORD', 'mikemak7667');
 */
define('ATTACHMENTS_DIR', "attachments");

// Get mail date to search for
$date_sql = "SELECT DATE_SUB(CURDATE(), 
				INTERVAL 1 DAY) AS start_date, 
				DATE_ADD(CURDATE(), INTERVAL 1 MONTH) AS expiry_date_1_month,
				DATE_ADD(CURDATE(), INTERVAL 12 MONTH) AS expiry_date_12_month";

$date_res = $conn->query($date_sql) or die(mysqli_error($conn));
$date_arr = $date_res->fetch_array();
//echo '<pre>'; print_r($date_arr); //exit;

$search_date = $date_arr['start_date'];
$expiry_date_arr['1 month'] = $date_arr['expiry_date_1_month'];
$expiry_date_arr['12 month'] = $date_arr['expiry_date_12_month'];
$search_date_unix = strtotime($date_arr['start_date']);
//echo '<br>date unix';
//echo $search_date_unix; //exit;

$mailbox = new ImapMailbox('{imap.gmail.com:993/imap/ssl}INBOX', GMAIL_EMAIL, GMAIL_PASSWORD, ATTACHMENTS_DIR, 'utf-8', $conn);
$mails = array();

$mailsIds = $mailbox->searchMailBox("UNSEEN");
//$mailsIds = $mailbox->searchMailBox("RECENT");

if (!$mailsIds) {
// There is no unread message in inbox
    die('Mailbox is empty');
} else {
    echo '<br>Total unseen =' . count($mailsIds) . '<br>';
}
//exit;
// We need to get latest emails first
$mailsIds = array_reverse($mailsIds);


$emailCount = 0;
if (isset($mailsIds)) {
    reset($mailsIds);
// Process only emails with subject "Summary of Automated Recurring Billing"
    $match_subject = 'Summary of Automated Recurring Billing';

    foreach ($mailsIds as $key => $value) {

        $mail = $mailbox->getMail($value);
        $emailDate = $mail->date;
        $emailDate_arr = explode(' ', $emailDate);
        $emailDate_unix = strtotime($emailDate_arr[0]);

        /*
          $fromName			=	$mail->fromName;
          $fromEmailAddress	=	$mail->fromAddress;
          $emailSubject		=	$mail->subject; */
//echo "\n". $mail->toString . "\n";

        $checkAttachments = true;
        $emailSubject = $mail->subject;

        echo $value . ' # ' . $emailSubject . '<br>';
//echo $search_date_unix.' | '.$emailDate_unix.'<br>';

        if ($emailSubject == $match_subject) {
            break;
        } else { // Mark other emails as unread
            $mailbox->markMailAsUnread($value);
        }

// Don't search inbox for old emails
        if ($search_date_unix > $emailDate_unix) {
            break;
        }

        if (APPMODE == "test") {
//$mailbox->markMailAsUnread($value);	
        }

        /* if($emailCount == 5) {
          break;
          } */

        $emailCount++;
    }

    echo '<br>Email received<br>';
    $authorize_net_csv_file_id = (isset($_SESSION['authorize_net_csv_file_id'])) ? $_SESSION['authorize_net_csv_file_id'] : '';
//    echo $authorize_net_csv_file_id; exit;

    if (!empty($authorize_net_csv_file_id)) {

        $sql = "SELECT * FROM tbl_user_recurring_billing_file WHERE pk_user_recurring_billing_file_id = $authorize_net_csv_file_id";
        $res = $conn->query($sql) or die(mysqli_error($conn));
        $res_row = $res->fetch_array();
        $successful_file = $res_row['user_recurring_billing_file_successful_file'];
        $failed_file = $res_row['user_recurring_billing_file_failed_file'];

// Read CSV file
        $start = 2; // Starting row
        $row = 1;
        $inputFile = ATTACHMENTS_DIR . '/' . $successful_file;
        $inputFailed = ATTACHMENTS_DIR . '/' . $failed_file;

// Read successfull csv file	
        if (($handle = fopen($inputFile, "r")) !== FALSE) {

            try {

                /* $affiliate_percentage = 80; // 80 %
                  $referrer_percentage = 20; // 80 % */

                $subscription_id_col = 0;
                $amount_col = 5;
                $payment_number_col = 2;
                $transaction_id_col = 4;

                while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {

                    $num = count($data);

                    $save_row = true;

// Skip rows
                    if ($row < $start) {
//echo $advertiser_fee; exit;
                        next($data);
                        $row++;
                        $save_row = false;
                    } else {
                        $row++;
                        $save_row = true;
                    }
                    $transaction_id = $data[$transaction_id_col];
                    $transaction_id = ($transaction_id) ? $transaction_id : '(NULL)';
                    $subscription_id = $data[$subscription_id_col];
                    $amount = $data[$amount_col];
                    $payment_number = $data[$payment_number_col];
                    $status = 'Unpaid';
                    $payment_type = '';
                    $expiry_date = '';

                    $dbInterval = getSubscriptionInterval($subscription_id, $conn);
                    var_dump($expiry_date_arr);
                    if ($dbInterval !== false) {
                        $first = 1;
                        foreach ($expiry_date_arr as $date) {
                            if ($first == 1) {
                                reset($expiry_date_arr);
                                $first = 0;
                            }
                            if (key($expiry_date_arr) == $dbInterval) {
                                $expiry_date = $date;
                            }
                            next($expiry_date_arr);
                        }
                    } else {
                        $status = 'conflict';
                    }

                    /* $commission_admin = ($amount * $affiliate_percentage) / 100;
                      $commission_referrer = ($amount * $referrer_percentage) / 100; */
                    if ($payment_number > 1 && $save_row == true) {
                        $payment_type = 'Recurring';
                    } else if ($payment_number == 1 && $save_row == true) {

                        $payment_type = 'New';
                    }
                    if ($save_row == true) {
                        $ins_sql = "INSERT INTO tbl_user_recurring_billing 
										SET user_recurring_billing_subscription_id='" . $subscription_id . "', 
											user_recurring_billing_transaction_id='" . $transaction_id . "' ,
											fk_user_recurring_billing_file_id='" . $authorize_net_csv_file_id . "', 
											user_recurring_billing_amount='" . $amount . "', 
											user_recurring_billing_payment_number='" . $payment_number . "', 
											user_recurring_billing_payment_type='" . $payment_type . "', 
											user_recurring_billing_billing_date='" . $emailDate . "' ,
											user_recurring_billing_expiry_date='" . $expiry_date . "',
											user_recurring_billing_status = '" . $status . "'";
                        $sql_res = $conn->query($ins_sql) or die(mysqli_error($conn));
                    }
                }

                fclose($handle);

// Set user_id for import data
// Update users table for status
                $imp_sql = "SELECT r.pk_user_recurring_billing_id AS 'id', u.pk_user_id AS user_id 
							FROM tbl_user_recurring_billing AS r 
							JOIN tbl_users AS u ON r.user_recurring_billing_subscription_id = u.user_authorize_net_sub_id
							WHERE r.fk_user_recurring_billing_file_id='" . $authorize_net_csv_file_id . "' GROUP BY u.pk_user_id";

                $sql_query = $conn->query($imp_sql) or die(mysqli_error($conn));

                while ($row = $sql_query->fetch_array()) {
                    $rid = $row['id'];
                    $user_id = $row['user_id'];
                    $sql_update = "UPDATE tbl_user_recurring_billing SET fk_user_id='$user_id' WHERE pk_user_recurring_billing_id='$rid'";
                    $conn->query($sql_update) or die(mysqli_error($conn));
                }
            } catch (Exception $e) { // an exception is raised if a query fails
                print_r($e);
//$transaction->rollBack();
            }
        }

#########################################################################
// Read failed csv file	
// Deactive users only whose transactions are failed
        if (($handle = fopen($inputFailed, "r")) !== FALSE) {

            try {

                $subscription_id_col = 0;
                $row = 1;
                $start = 2; // Starting row

                echo "<hr>";
                echo "Users downgraded to Shopper \n";
                while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
                    $num = count($data);
                    $save_row = true;
// Skip rows
                    if ($row < $start) {
//echo $advertiser_fee; exit;
                        next($data);
                        $row++;
                        $save_row = false;
                    } else {
                        $row++;
                        $save_row = true;
                    }

                    $subscription_id = $data[$subscription_id_col];
                    echo '<br> Subscription Id: ' . $subscription_id . '<br>';

                    if ($save_row == true) {

                        echo '<br>==========  User Set to SHOPPER ==============<br>';

                        $userId = getUserId($subscription_id, $conn);
                        echo '<br>Downgrade user id: ' . $userId;

                        if ($userId !== false) {

                            $update_sql = "UPDATE tbl_user_to_user_account_type_log
                                            SET user_account_log_status = 'Inactive'
                                            WHERE fk_user_id = '" . $userId . "'";
                            
                            $conn->query($update_sql) or die(mysqli_error($conn));

                            $newAccId = "INSERT INTO tbl_user_to_user_account_type_log 
										SET fk_user_id = " . $userId . ",
										fk_user_account_type_id = '5',
										user_account_log_status = 'Active',
                                                                                user_account_log_create_date = NOW()";
                            
                            $conn->query($newAccId) or die(mysqli_error($conn));

                            $userData = getUserData($userId, $conn);
                            $fullName = $userData['user_first_name'] . ' ' . $userData['user_last_name'];

                            echo '<br>User full name: ' . $fullName;
                            echo '<br>========== User Set to SHOPPER ==============<br>';
                            echo '<br>========== Email Notification ==============<br>';
                            $email = getemailInfo(18, $conn);
                            $tags = array("{full-name}", "{upgrade-url}", "{live-chat}", "{web-store-url}", "{THEME_URL}");
                            $replace = array($fullName, BASE_URL.'/'.$userData['user_username'].'/upgrade-info', BASE_URL.'/liveSupport', BASE_URL.'/'.$userData['user_username'], THEME_URL);
                            $subject = $email['email_title'];
                            $message = prepEmail($tags, $replace, $email['email_description']);
                            echo '<br>============ End Email Message ==============<br>';
                            echo '=======Send Email: ';
                            echo sendEmail($userData['user_email'], 'noreply@karmora.com', $subject, $message);
                            echo '<br>========== Email Notification ==============<br>';
                        }
                    }
                }

                fclose($handle);
            } catch (Exception $e) { // an exception is raised if a query fails
                print_r($e);
            }
        }
        $conn->close();
    }
}

function getSubscriptionInterval($subId, $conn) {
    $query = "SELECT acc_bil.user_account_billing_properties_arb_type
				FROM tbl_users AS u
				LEFT JOIN view_affiliate_banner_info AS v_ab ON u.pk_user_id = v_ab._member_id
				LEFT JOIN tbl_user_account_type AS acc_type ON v_ab.user_acc_type_id = acc_type.pk_user_account_type_id
				LEFT JOIN tbl_user_account_billing_properties AS acc_bil ON acc_type.fk_user_account_billing_properties_id = acc_bil.pk_user_account_billing_properties
				WHERE u.user_authorize_net_sub_id ='" . $subId . "'";
//echo $query;exit;
    $sql_res = $conn->query($query) or die(mysqli_error($conn));
    $date_arr = $sql_res->fetch_array();
    if (!empty($date_arr)) {
        $response = $date_arr[0];
    } else {
        $response = false;
    }
    return $response;
}

function getUserId($subId, $conn) {
    $query = "SELECT pk_user_id FROM tbl_users AS u WHERE u.user_authorize_net_sub_id = '" . $subId . "'";
//    echo $query;
    $sql_res = $conn->query($query) or die(mysqli_error($conn));
    $date_arr = $sql_res->fetch_array();
    if (!empty($date_arr)) {
        $response = $date_arr[0];
    } else {
        $response = false;
    }
//    var_dump($response);exit;
    return $response;
}

function prepEmail($tags, $replace, $content) {
    
    $header = str_replace('{THEME_URL}', THEME_URL, file_get_contents(BASE_PATH. '/crons/read_mail_inbox/email/emailheader.php'));
    $footer = str_replace('{THEME_URL}', THEME_URL, file_get_contents(BASE_PATH.'/crons/read_mail_inbox/email/emailfooter.php'));
    $messageWithTags = $header.$content.$footer;
    $message = str_replace($tags, $replace, $messageWithTags);
    return $message;
}

function sendEmail($recipient_emails, $from, $subject, $message) {
    /*
      $obj = new $conn;
      $message = addcslashes($message);
      $insertQuery = "INSERT INTO tbl_email_queue
      SET email_queue_recipient= :recipient_emails,
      email_queue_from= :from,
      email_queue_subject= :subject,
      email_queue_message = :message";
      $statement = $obj->prepare($insertQuery);
      $statement->bind_param(':recipient_emails', $recipient_emails);
      $statement->bind_param(':from', $from);
      $statement->bind_param(':subject', $subject );
      $statement->bind_param(':message', $message);

      $statement->execute();
      $statement->close();
      $obj->close();
     * 
     */

    $headers = "From: " . $from . "\r\n";
    $headers .= "Reply-To: " . $from . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    //send email
    $mail_sent = @mail( $recipient_emails, $subject, $message, $headers );

    return $mail_sent;
}

function getemailInfo($id, $conn) {
    $query = "select * from tbl_email where pk_email_id=$id LIMIT 1";

    $sql_res = $conn->query($query) or die(mysqli_error($conn));
    $date_arr = $sql_res->fetch_array();
    if (!empty($date_arr)) {
        $response = $date_arr;
    } else {
        $response = false;
    }
    return $response;
}

function getUserData($id, $conn) {
    $query = "SELECT * FROM tbl_users WHERE pk_user_id = $id LIMIT 1";

    $sql_res = $conn->query($query) or die(mysqli_error($conn));
    $date_arr = $sql_res->fetch_array();
    if (!empty($date_arr)) {
        $response = $date_arr;
    } else {
        $response = false;
    }
    return $response;
}
