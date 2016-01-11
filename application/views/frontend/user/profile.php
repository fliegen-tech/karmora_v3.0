
<div class="container" id="profile-container"> <?php echo $nav;  ?>

    <div class="row">
        <h2 id="profile-header" class="profile-header">Profile</h2>
    </div>
    <div class="row midrow" id="profile-row">
        <?php if (!empty($userData)) { ?>
            <div class="col-xs-12 col-sm-6 col-md-6" id="left-col">
                <form class="form-horizontal" role="form" method="post" action="<?php echo base_url() ?>editprofile">
                    <fieldset>
                        <h3 class="col-title ">Basic Information</h3>
                        <?php
                        if ($this->session->flashdata('success')) {
                            ?>
                            <div class="alert alert-info" role="alert">Profile Saved</div>
                            <?php
                        }
                        ?>
                        <?php
                        if ($this->session->flashdata('profile_err')) {
                            ?>
                            <div class="alert alert-danger" role="alert">Complete the details</div>
                            <?php
                        }
                        ?>

                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-sm-4 col-md-3 control-label" for="textinput">Username</label>
                            <input type="text" name="username" class=" col-xs-12  col-md-8" value="<?php echo $userData['user_username'] ?>"  readonly="readonly"/>
                        </div>


                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-sm-4 col-md-3 control-label" for="textinput">First Name</label>
                            <input type="text" class=" col-xs-12  col-md-8" name="fname" value="<?php echo $userData['user_first_name'] ?>"/>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-sm-4 col-md-3 control-label" for="textinput">Last Name</label>
                            <input type="text"  class=" col-xs-12  col-md-8" name="lname" value="<?php echo $userData['user_last_name'] ?>" />
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-sm-4 col-md-3 control-label" for="textinput">Email</label>
                            <input type="text"  class=" col-xs-12  col-md-8" name="email" value="<?php echo $userData['user_email']; ?>" />
                        </div>

                        <!-- Text input-->

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-10" style="padding:0px;">
                                <div class=" pull-left btn-gap">
                                    <button type="submit" class="btn btn-default">Update</button>
                                    <button type="reset" class="btn btn-default">Cancel</button>
                                    <input type="hidden" name="action" value="edit_profile" />
                                    <input type="hidden" name="userId" value="<?php echo $userData['pk_user_id'] ?>" />
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        <?php } ?>

        <!------left-col------->
        <div class="col-xs-12 col-sm-6 col-md-6" id="right-col">
            <form class="form-horizontal" role="form" method="post" action="<?php echo base_url() ?>editprofile">
                <fieldset>
                    <h3 class="col-title">Change Password</h3>
                    <?php
                    if ($this->session->flashdata('pass_err')) {
                        ?>
                        <div class="alert alert-danger" role="alert">Password Miss match</div>
                        <?php
                    } else if ($this->session->flashdata('pass_succ')) {
                        ?>
                        <div class="alert alert-info" role="alert">Password Changed</div>
                        <?php
                    }
                    ?>
                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-sm-4 col-md-4 control-label" for="textinput">Current Password</label>
                        <input type="password"  class=" col-xs-12  col-md-8" name="curr_password" />
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-sm-4 col-md-4 control-label" for="textinput">New Password</label>
                        <input type="password" placeholder="" class=" col-xs-12  col-md-8" name="password" />
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-sm-4 col-md-4 control-label" for="textinput">Confirm Password</label>
                        <input type="password" placeholder="" class=" col-xs-12  col-md-8" name="confirm_password" />
                        <input type="hidden" name="action" value="change_password" />
                    </div>

                    <!-- Text input--> 
                    <!-- Text input-->
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-10">
                            <div class="col-sm-12 ">
                                <div class=" pull-left ">
                                    <button type="submit" class="btn btn-default">Update</button>
                                    <button type="submit" class="btn btn-default">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        <!------left-col------->
        <div class="clearfix"></div>
    </div>

    <!-- ---------------------START ADDRESS ---------------------------- -->

    <div class="row" id="profile-row">
        <div class="col-xs-12 col-sm-6 col-md-6" id="left-col">
            <form method="post" class="form-horizontal" role="form" action="<?php echo base_url('editprofile'); ?>">
                <fieldset>
                    <h3 class="col-title">Mailing Address</h3>
                    <?php
                    if ($this->session->flashdata('address_success')) {
                        ?>
                        <div class="alert alert-info" role="alert"><?php echo $this->session->flashdata('address_success'); ?></div>
                        <?php
                    } elseif ($this->session->flashdata('address_err')) {
                        ?>
                        <div class="alert alert-danger" role="alert"> <?php echo $this->session->flashdata('address_err'); ?></div>
                        <?php
                    }
                    ?>

                    <!-- Start Address Line-->
                    <div class="form-group">
                        <label class="col-sm-4 col-md-3 control-label" for="textinput">Address 1</label>
                        <input name="street_address" type="text" required="required" class=" col-xs-12  col-md-8" <?php if ($address === false) { ?> value=""<?php } else { ?>value="<?php echo $address['street_address']; ?>"<?php } ?> />
                    </div>
                    <!-- End Address Line-->
                    <div class="form-group">
                        <label class="col-sm-4 col-md-3 control-label" for="textinput">Address 2</label>
                        <input name="street_address_2" type="text" class=" col-xs-12  col-md-8" <?php if ($address === false) { ?> value=""<?php } else { ?>value="<?php echo $address['street_address_2']; ?>"<?php } ?> />
                    </div>

                    <!-- Start City -->
                    <div class="form-group">
                        <label class="col-sm-4 col-md-3 control-label" for="textinput">City</label>
                        <input name="city" type="text" required="required" class=" col-xs-12  col-md-8" <?php if ($address === false) { ?> value=""<?php } else { ?>value="<?php echo $address['city']; ?>"<?php } ?> />
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 col-md-3 control-label" for="textinput">State</label>

                        <select id="statesList" name="state" required class=" col-xs-12  col-md-8">
                            <?php if ($address === false) { ?>
                                <option selected="selected" disabled="disabled">--- Select State ---</option>
                            <?php
                            }
                            if ($statesList !== false) {
                                $first = true;
                                foreach ($statesList as $state) {
                                    if ($first) {
                                        reset($statesList);
                                        $first = false;
                                    }
                                    ?>
                                    <option value="<?php echo $state['optionVal'] ?>" <?php if ($state['pk_user_address_state_id'] === $address['state_id']) { ?> selected="selected" <?php } ?>> <?php echo $state['user_address_state_code'] . ' - ' . $state['user_address_state_title']; ?> </option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                    <!-- End State -->
                    <div class="form-group">
                        <label class="col-sm-4 col-md-3 control-label" for="textinput">Zip Code</label>
                        <input name="zipcode" type="text" class=" col-xs-12  col-md-8" <?php if ($address === false) { ?> value=""<?php } else { ?>value="<?php echo $address['zipcode']; ?>"<?php } ?> />
                    </div>
                    <!--Start Country -->
                    <div class="form-group">
                        <label class="col-sm-4 col-md-3 control-label" for="textinput">Country</label>
                        <select id="countriesList" name="country" required placeholder="Country" class=" col-xs-12  col-md-8" <!--onchange="getStatesofSelectedCountry(this.value)"-->>
                                    <?php if ($address === false) { ?>
                                    <option selected="selected" disabled="disabled">--- Select Country ---</option>
                                        <?php
                                    }
                                    if ($countriesList !== false) {
                                        $first = true;
                                        foreach ($countriesList as $country) {
                                            if ($first) {
                                                reset($countriesList);
                                                $first = false;
                                            }
                                            ?>
                                    <option value="<?php echo $country['pk_user_address_country_id'] ?>" <?php if ($address !== false && $country['pk_user_address_country_id'] === $address['country_id']) { ?> selected="selected" <?php } ?>> <?php echo $country['user_address_country_code'] . ' - ' . $country['user_address_country_title'] ?> </option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <!--End Country -->
                    <div class="form-group">
                        <label class="col-sm-4 col-md-3 control-label" for="textinput">Phone No</label>
                        <input type="text"  class=" col-xs-12  col-md-8" name="phone" value="<?php echo $userData['user_phone_no']; ?>"/>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-10" style="padding:0px;">
                            <div class=" pull-left btn-gap">
                                <input type="hidden" name="action" value="address_update" />
                                <input type="hidden" name="userId" value="<?php echo $userData['pk_user_id']; ?>" />
                                <button type="submit" class="btn btn-default">Update</button>
                                <button type="reset" class="btn btn-default">Cancel</button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>

        <!-- ---------------------END ADDRESS ---------------------------- --> 

        <!------left-col------->
        <div class="col-xs-12 col-sm-6 col-md-6" id="right-col">
            <h3 class="col-title">Change Profile Picture</h3>
            <div class="row form-group"> <span class="col-md-5 ">
                    <?php if ($pic) { ?>
                        <img src="<?php echo $themeUrl . '/images/profile-pic/' . $userData['pk_user_id'] . '/' . $pic[0]['profile_user_picture_image_name']; ?>" class="img-responsive col-xs-12">
                    <?php } else { ?>
                        <img src="<?php echo $themeUrl . '/images/profile-pic/default.png'; ?>" class="img-responsive col-xs-12">
<?php } ?>
                </span> </div>
            <form enctype="multipart/form-data" id="upload" action="<?php echo base_url() ?>profile/upload" method="post">
                <div id="drop"><a class="btn btn-default">Browse</a>
                    <input type="file" name="upl" />
                </div>
                <ul>
                    <!-- The file uploads will be shown here -->
                </ul>
            </form>

            <!------left-col-------> 

        </div>
    </div>
    <div class="row" id="profile-row">

            <?php if (isset($email_types) && !empty($email_types)) { ?> 
            <div class=" col-xs-12 col-sm-12 col-md-12">
                <h3 class="col-title">Manage Karmora Emails</h3>
                <?php if ($this->session->flashdata('email_succ')) { ?>
                    <div class="alert alert-info" role="alert">Changes Saved</div>
                    <?php } ?>
                <form method="post" action="<?php echo base_url() ?>profile/emails">
                    <?php foreach ($email_types as $email_types) { ?>
                        <p class="lead text-left">
                            <input type="checkbox"  class="col-xs-1 col-sm-1 col-md-1 check-left check" name="emails[]" value="<?php echo $email_types->fk_email_type_id; ?>" <?php
                            if ($email_types->email_type_to_user_relation_status === "Active") {
                                echo "checked = checked";
                            }
                            ?>>
                        <?php echo ucfirst($email_types->email_type_description); ?> </p>
                        <?php
                    }
                    ?>
                    <p class="lead text-left">
                        <input type="checkbox" class="col-xs-1 col-sm-1 col-md-1 check-left" name="uncheck" value="uncheck" id="uncheck"/>
                        Please STOP all Karmora emails</p>
                    <input type="hidden" name="userId" value="<?php echo $email_types->fk_user_id; ?>" />
                    <div class="form-group">
                        <div class=" col-sm-10">
                            <div class=" pull-left">
                                <button type="submit" class="btn btn-default">Update</button>
                                <button type="submit" class="btn btn-default">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
<?php } ?>  

    </div>
    <!--------profile-container------> 
</div>

<?php $this->load->view('frontend/user/profile_js'); ?>