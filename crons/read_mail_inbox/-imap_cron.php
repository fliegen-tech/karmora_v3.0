<?php //ini_set('error_reporting', E_ALL);
session_start();
ini_set('max_execution_time', 5 * 60); //300 seconds = 5 minutes
ini_set('memory_limit', '999M');

require_once('../conn.php');
require_once("lib/ImapMailbox.php");

define('APPMODE', 'test');
/*
promokarmora1@gmail.com
$karmora123
*/
define('GMAIL_EMAIL', 'shopkarmora@gmail.com');
define('GMAIL_PASSWORD', 'mikemak7667');
define('ATTACHMENTS_DIR', "attachments");

// Get mail date to search for
$date_sql = "SELECT DATE_SUB(CURDATE(), INTERVAL 1 DAY) AS start_date, DATE_ADD(CURDATE(), INTERVAL 1 MONTH) AS expiry_date";

$date_res = $conn->query($date_sql) or die(mysqli_error($conn));
$date_arr = $date_res->fetch_array();
//echo '<pre>'; print_r($date_arr); exit;

$search_date = $date_arr['start_date'];
$expiry_date = $date_arr['expiry_date'];
$search_date_unix = strtotime($date_arr['start_date']);
//echo $search_date_unix; exit;

$mailbox = new ImapMailbox('{imap.gmail.com:993/imap/ssl}INBOX', GMAIL_EMAIL, GMAIL_PASSWORD, ATTACHMENTS_DIR, 'utf-8', $conn);
$mails = array();

$mailsIds = $mailbox->searchMailBox("UNSEEN");
//$mailsIds = $mailbox->searchMailBox("RECENT");

if (!$mailsIds) {
    // There is no unread message in inbox
    die('Mailbox is empty');
} else {
    echo 'Total unseen =' . count($mailsIds) . '<br>';
}

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
    //echo $authorize_net_csv_file_id; exit;

    if (!empty($authorize_net_csv_file_id)) {

        $sql = "SELECT * FROM authorize_net_csv_files WHERE id = $authorize_net_csv_file_id";
        $res = $conn->query($sql) or die(mysqli_error());
        $res_row = $res->fetch_array();
        $successful_file = $res_row['successful_file'];
        $failed_file = $res_row['failed_file'];

        // Read CSV file
        $start = 2; // Starting row
        $row = 1;
        $inputFile = ATTACHMENTS_DIR . '/' . $successful_file;
        $inputFailed = ATTACHMENTS_DIR . '/' . $failed_file;

        // Read successfull csv file	
        if (($handle = fopen($inputFile, "r")) !== FALSE) {

            try {

                $affiliate_percentage = 80; // 80 %
                $referrer_percentage = 20; // 80 %

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

                    $transaction_id = (int) $data[$transaction_id_col];
                    $transaction_id = ($transaction_id) ? $transaction_id : '(NULL)';
                    $subscription_id = $data[$subscription_id_col];
                    $amount = $data[$amount_col];
                    $payment_number = $data[$payment_number_col];

                    $commission_admin = ($amount * $affiliate_percentage) / 100;
                    $commission_referrer = ($amount * $referrer_percentage) / 100;

                    if ($payment_number > 1 && $save_row == true) {

                        $payment_type = 'Recurring';
                        $ins_sql = "INSERT INTO users_recurring_billing SET subscription_id='$subscription_id', transaction_id='$transaction_id' ";
                        $ins_sql .= " ,authorize_net_csv_file_id='$authorize_net_csv_file_id', amount='$amount', commission_referrer='$commission_referrer'";
                        $ins_sql .= " ,commission_admin='$commission_admin', payment_number='$payment_number', payment_type='$payment_type', billing_date='$emailDate'";
                        $ins_sql .= " ,created=NOW(), expiry_date='$expiry_date'";
                        $sql_res = $conn->query($ins_sql) or die(mysqli_error($conn));
                    } else if ($payment_number == 1 && $save_row == true) {

                        $payment_type = 'New';
                        $ins_sql = "UPDATE users_recurring_billing SET transaction_id='$transaction_id' ";
                        $ins_sql .= " ,authorize_net_csv_file_id='$authorize_net_csv_file_id', amount='$amount', commission_referrer='$commission_referrer'";
                        $ins_sql .= " ,commission_admin='$commission_admin', billing_date='$emailDate'";
                        $ins_sql .= "  WHERE subscription_id='$subscription_id'";
                        $sql_res = $conn->query($ins_sql) or die(mysqli_error($conn));
                    }
                }

                fclose($handle);

                // Set user_id for import data
                // Update users table for status
                //$imp_sql = "SELECT R.id, R.subscription_id, U.id AS user_id FROM users_recurring_billing AS R";
                $imp_sql = "SELECT R.id, R.subscription_id, U.id AS user_id, U.referrer FROM users_recurring_billing AS R";
                $imp_sql .= " JOIN users as U ON R.subscription_id=U.authorize_net_sub_id WHERE R.authorize_net_csv_file_id='$authorize_net_csv_file_id'";
                $imp_sql .= " GROUP BY U.id";
                $sql_query = $conn->query($imp_sql) or die(mysqli_error($conn));

                while ($row = $sql_query->fetch_array()) {
                    $rid = $row['id'];
                    $user_id = $row['user_id'];
                    $referrer_id = $row['referrer'];
                    $sql_update = "UPDATE users_recurring_billing SET user_id='$user_id', referrer_id='$referrer_id' WHERE id='$rid'";
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
				echo "Deactive users \n";
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
                    echo $subscription_id . '<br>';

                    if ($save_row == true) {

                        $update_sql = "UPDATE users SET status='inactive' WHERE authorize_net_sub_id='$subscription_id'";
                        //echo $update_sql.'<br>'; exit;
                        $sql_res = $conn->query($update_sql) or die(mysqli_error($conn));
                    }
                }

                fclose($handle);
            } catch (Exception $e) { // an exception is raised if a query fails
                print_r($e);
                //$transaction->rollBack();
            }
        }
    }
    // Unset session for file id
    //unset($_SESSION['authorize_net_csv_file_id']);
} 