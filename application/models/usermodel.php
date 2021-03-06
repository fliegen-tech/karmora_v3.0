<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usermodel
 *
 * @usamn
 */
class usermodel extends commonmodel {

    public function editProfile($data) {
        $fname = $data['fname'];
        $lname = $data['lname'];
        $email = $data['email'];
        $phone = '';
        $userId = $data['userId'];
        $sql = "UPDATE tbl_users SET"
                . " `user_first_name`    =   '$fname',"
                . "`user_last_name` =   '$lname',"
                . "`user_email` =   '$email',"
                . "`user_phone_no`  =   '$phone'"
                . " where `pk_user_id`   =   $userId";
        $statement = $this->db->conn_id->prepare($sql);
        if ($statement->execute()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function changePassword($data, $id) {
        $password = md5($data['password']);
        $sql = "Update tbl_users set user_password = '$password' where pk_user_id = $id";
        $statement = $this->db->conn_id->prepare($sql);
        if ($statement->execute()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // function to debug PDO queries
    private function parms($string, $data) {
        $indexed = $data == array_values($data);
        foreach ($data as $k => $v) {
            if (is_string($v))
                $v = "'$v'";
            if ($indexed)
                $string = preg_replace('/\?/', $v, $string, 1);
            else
                $string = str_replace(":$k", $v, $string);
        }
        return $string;
    }

    public function updateAddress($data) {
        //set all previous address for user to false
        $setAllAddressInactiveQuery = "UPDATE tbl_user_address AS uadd SET uadd.user_address_current = 'false' WHERE uadd.fk_users_id = " . $data['userId'];
        //echo $setAllAddressInactiveQuery;exit;

        $statement = $this->db->conn_id->prepare($setAllAddressInactiveQuery);
        $statement->execute();
        $userId = $data['userId'];
        $streetAddress = $data['streetAddress'];
        $streetAddress_2 = $data['streetAddress_2'];
        $city = $data['city'];
        $zipCode = $data['zipCode'];
        $stateId = $data['stateId'];
        $countryId = $data['countryId'];
        $insertAddressQuery = "INSERT INTO tbl_user_address
                                SET 
                                    fk_users_id = :userId,
                                    user_address_street_address = :streeAddress,
                                    user_address_street_address_2 = :streeAddress_2,
                                    user_address_city_name = :city,
                                    user_address_zip_code = :zipCode,
                                    fk_user_address_state_id = :stateId,
                                    fk_user_address_country_id = :countryId,
                                    user_address_create_date = NOW(),
                                    user_address_current = 'true'";
        $insertStatement = $this->db->conn_id->prepare($insertAddressQuery);

        $insertStatement->bindParam(':userId', $userId, PDO::PARAM_STR);
        $insertStatement->bindParam(':streeAddress', $streetAddress, PDO::PARAM_STR);
        $insertStatement->bindParam(':streeAddress_2', $streetAddress_2, PDO::PARAM_STR);
        $insertStatement->bindParam(':city', $city, PDO::PARAM_STR);
        $insertStatement->bindParam(':zipCode', $zipCode, PDO::PARAM_STR);
        $insertStatement->bindParam(':stateId', $stateId, PDO::PARAM_STR);
        $insertStatement->bindParam(':countryId', $countryId, PDO::PARAM_STR);

        if ($insertStatement->execute()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function validateCountryStateCity($cscData) {
        //var_dump($cscData);exit;
        $query = "SELECT * 
                    FROM view_user_address_current AS vuac
                    WHERE 
                    vuac.member_id = " . $cscData['userId'] . " AND
                    vuac.address = '" . $cscData['streetAddress'] . "' AND
                    vuac.address_2 = '" . $cscData['streetAddress_2'] . "' AND
                    vuac.city = '" . $cscData['city'] . "' AND
                    vuac.zip_code = " . $cscData['zipCode'] . " AND
                    vuac.state_id = " . $cscData['stateId'] . " AND
                    vuac.country_id = " . $cscData['countryId'];
        //echo $query;
        $validate = $this->runDbQuery($query);
        //echo count($validate);exit;
        if (count($validate) !== 1) {
            $response = false;
        } else {
            $response = true;
        }
        return $response;
    }

    public function getMemberCurrentAddress($member_id = null) {
        $response = '';
        if ($member_id !== null) {
            $query = "SELECT *
                        FROM view_member_address AS addr
                        WHERE addr.member_id = $member_id AND addr.address_current = 'true' LIMIT 1";
            $statement = $this->db->conn_id->prepare($query);
            $statement->execute();
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);

            if (count($data) > 0) {
                $response['address'] = $data[0];
                //var_dump($response['address']);exit;
            } else {

                $response['address'] = FALSE;
                $response['statesOfCurrentAddressCountry'] = $this->getStatesofCountry(1);
            }
            //count($data)>0 ? $response['address'] = $data[0] : $response['address'] = false;
            /*
              if (count($data) > 0) {
              $response['address'] = $data[0];
              } else {
              $response['address'] = false;
              }
             * 
             */
        } else {
            $response['address'] = false;
        }

        $response['countriesList'] = $this->getCountries();
        $response['address'] !== false ?
                        $response['statesOfCurrentAddressCountry'] = $this->getStatesofCountry(1) :
                        //$response['statesOfCurrentAddressCountry'] = false;
                        /*
                          if ($response['address'] !== false) {
                          $response['statesOfCurrentAddressCountry'] = $this->getStatesofCountry($data[0]['country_id']);
                          } else {
                          $response['statesOfCurrentAddressCountry'] = false;
                          }
                         * 
                         */
                        $response['address'] !== false ?
                                $response['citiesOfCurrentAddressState'] = $this->getCitiesofStates($data[0]['country_id'], $data[0]['state_id']) :
                                $response['citiesOfCurrentAddressState'] = false;
        /*
          if ($response['address'] !== false) {
          $response['citiesOfCurrentAddressState'] = $this->getCitiesofStates($data[0]['country_id'], $data[0]['state_id']);
          } else {
          $response['citiesOfCurrentAddressState'] = false;
          }
         * 
         */
        /* echo'<pre>';
          print_r($response);
          exit; */

        return $response;
    }

    private function getCountries() {
        $query = "SELECT *
					FROM tbl_user_address_country AS country
					WHERE country.user_address_status = 'active' 
					ORDER BY country.user_address_country_title";
        return $this->runDbQuery($query);
    }

    public function getStatesofCountry($countryId = null) {
        if ($countryId !== null) {
            $query = "SELECT *
					FROM tbl_user_address_state AS state
					WHERE state.fk_user_address_country_id = $countryId
					ORDER BY state.user_address_state_title
					";
            $response = $this->runDbQuery($query);
            if (!empty($response)) {
                $first = true;
                foreach ($response as $state) {
                    if ($first === true) {
                        reset($response);
                        $first = false;
                    }
                    $response[key($response)]['optionVal'] = $countryId . '-.-' . $state['pk_user_address_state_id'];
                    next($response);
                }
            }
        } else {
            $response = false;
        }
        /* echo '<pre>';
          print_r($response);
          exit; */
        return $response;
    }

    public function getCitiesofStates($countryId = null, $stateId = null) {
        if ($countryId !== null && $stateId !== null) {
            $query = "SELECT *
					FROM tbl_user_address_city AS city
					LEFT JOIN tbl_user_address_state AS state ON city.fk_user_address_state_id = state.pk_user_address_state_id
					WHERE city.fk_user_address_state_id = $stateId AND
							state.fk_user_address_country_id = $countryId
					ORDER BY city.user_address_city_zip_code ASC";

            $query1 = "SELECT DISTINCT city.user_address_city_title AS 'city_title'
					FROM tbl_user_address_city AS city
					LEFT JOIN tbl_user_address_state AS state ON city.fk_user_address_state_id = state.pk_user_address_state_id
					WHERE city.fk_user_address_state_id = $stateId AND
							state.fk_user_address_country_id = $countryId
					ORDER BY city.user_address_city_title
					";

            $response['city'] = $this->runDbQuery($query);
            $response['cityNames'] = $this->runDbQuery($query1);

            if ($response['cityNames'] !== false) {
                $first = true;
                foreach ($response['cityNames'] as $cityName) {
                    if ($first === true) {
                        reset($response['cityNames']);
                        $first = false;
                    }
                    $response['cityNames'][key($response['cityNames'])]['optionVal'] = $countryId . '-.-' . $stateId . '-.-' . $cityName['city_title'];
                    next($response['cityNames']);
                }
            }
            //var_dump($response['cityNames']);exit;
        } else {
            $response = false;
        }
        /* echo '<pre>';
          print_r($response);
          exit; */
        return $response;
    }

    public function getZipCodesOfCity($countryId = null, $stateId = null, $cityName = null) {
        //echo $countryId.'<br>'.$stateId.'<br>'.$cityName;exit;
        if ($countryId !== null && $stateId !== null && $cityName !== null) {
            $query = "SELECT *
					FROM tbl_user_address_city AS city
					LEFT JOIN tbl_user_address_state AS state ON city.fk_user_address_state_id = state.pk_user_address_state_id
					WHERE city.user_address_city_title = '" . $cityName . "' AND
							city.fk_user_address_state_id = $stateId AND
							state.fk_user_address_country_id = $countryId 					
					ORDER BY city.user_address_city_zip_code ASC";
            //echo $query;exit;
            $response = $this->runDbQuery($query);
            //var_dump($response);
            //exit;
        } else {
            $response = false;
        }
        return $response;
    }

    // get list of all Country States and Cities
    private function getCitySateCountryList() {
        $queryList['country'] = "SELECT *
								FROM tbl_user_address_country AS country
								WHERE country.user_address_status = 'active'
								ORDER BY state.user_address_state_title";
        $queryList['state'] = "SELECT *
							FROM tbl_user_address_state AS state
							WHERE 1
							ORDER BY state.user_address_state_title";
        $queryList['city'] = "SELECT *
							FROM tbl_user_address_city AS city
							WHERE 1
							ORDER BY state.user_address_state_title";
        $first = true;
        foreach ($queryList as $query) {
            if ($first) {
                reset($queryList);
                $first = false;
            }
            $reponse[key($queryList)] = $this->runDbQuery($query);
            next($queryList);
        }

        return $reponse;
    }

    private function runDbQuery($query) {
        $statement = $this->db->conn_id->prepare($query);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($data > 0)) {
            $response = $data;
        } else {
            $response = false;
        }
        return $response;
    }

    // function to get user address in.
    // function to get user picture
    public function checkProfilePic($userId) {
        $sql = "select * from tbl_user_profile_picture where fk_user_id = $userId  AND profile_user_picture_status='Active'";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($data) > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }

    // function to set profile picture
    public function setProfilePic($userId, $data) {
        $pic_name = $data['picname'];
        $user_id = $userId;
        $sql = "INSERT INTO  tbl_user_profile_picture  SET"
                . " `profile_user_picture_image_name`    =   :picname,"
                . "`fk_user_id` = " . $user_id;

        $statement = $this->db->conn_id->prepare($sql);
        $statement->bindParam(':picname', $pic_name, PDO::PARAM_STR);
        // $statement->bindParam(':userid', $user_id, PDO::PARAM_INT);
        //$statement->bindParam(':id',$userId,  PDO::PARAM_INT);
        // echo $this->parms($sql, $data);
        echo $this->parms($sql, $data);
        if ($statement->execute()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function updatePhone($userId, $phone) {
        $sql = "update tbl_users set `user_phone_no` = :phone where pk_user_id = $userId";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->bindParam(':phone', $phone, PDO::PARAM_STR);
        if ($statement->execute()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getUserEmails($userId) {
        $sql = "SELECT * FROM tbl_email_type_to_user_relation, tbl_email_type WHERE tbl_email_type_to_user_relation.fk_email_type_id = tbl_email_type.pk_email_type_id
AND tbl_email_type_to_user_relation.fk_user_id = $userId GROUP BY tbl_email_type_to_user_relation.fk_email_type_id";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_OBJ);
        if (count($result) > 0) {
            return $result;
        } else {
            return FALSE;
        }
    }

    public function getCurrentEmails($userId) {
        $sql = "SELECT fk_email_type_id FROM tbl_email_type_to_user_relation WHERE tbl_email_type_to_user_relation.fk_user_id = $userId";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            return $result;
        } else {
            return FALSE;
        }
    }

    public function changeEmailSub($string, $userId) {
        $sqlInactive = "UPDATE tbl_email_type_to_user_relation SET email_type_to_user_relation_status = 'Inactive' WHERE fk_user_id = $userId AND fk_email_type_id
NOT IN ($string)";
        $statementInactive = $this->db->conn_id->prepare($sqlInactive);
        if ($statementInactive->execute()) {
            $sqlActive = "UPDATE tbl_email_type_to_user_relation SET email_type_to_user_relation_status = 'Active' WHERE fk_user_id = $userId AND fk_email_type_id
 IN ($string)";
            $statementActive = $this->db->conn_id->prepare($sqlActive);
            $statementActive->execute();
        }

        return TRUE;
    }

    public function changeEmailAll($userId) {
        $sql = "update tbl_email_type_to_user_relation SET email_type_to_user_relation_status = 'Inactive' WHERE fk_user_id = $userId";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
    }

}
