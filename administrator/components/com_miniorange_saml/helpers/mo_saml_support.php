<?php
defined('_JEXEC') or die;
/*
 * @package    miniOrange
 * @subpackage Plugins
 * @license    GNU/GPLv3
 * @copyright  Copyright 2015 miniOrange. All Rights Reserved.
*/
JHtml::_('stylesheet', JUri::base() .'components/com_miniorange_saml/assets/css/miniorange_boot.css');

function mo_saml_local_support(){
	$strJsonFileContents = file_get_contents(__DIR__ . '/../assets/json/timezones.json'); 
	$timezoneJsonArray = json_decode($strJsonFileContents, true);
    
    $current_user = JFactory::getUser();
    $result       = (new Mo_saml_Local_Util)->_load_db_values('#__miniorange_saml_customer_details');
    $admin_email  = isset($result['email']) ? $result['email'] : '';
    $admin_phone  = isset($result['admin_phone']) ? $result['admin_phone'] : '';
	if($admin_email == '')
		$admin_email = $current_user->email;
	?>
	<div id="sp_support_saml">
		<div class="mo_boot_row mo_boot_p-3 mo_tab_border">
			<div class="mo_boot_col-sm-12">
				<div class="mo_boot_row">
                    <div class="mo_boot_col-sm-12 mo_boot_p-2">
                        <h4><?php echo JText::_('COM_MINIORANGE_SAML_SUPPORT'); ?></h4>
                    </div>
				</div>
				<hr>
			</div>
			<div class="mo_boot_col-sm-12">
				<form  name="f" method="post" action="<?php echo JRoute::_('index.php?option=com_miniorange_saml&task=myaccount.contactUs');?>">
                    <div class="mo_boot_col-sm-12">	
                        <div class="mo_boot_row">
                            <div class="mo_boot_col-sm-2">
                                <img src="<?php echo JUri::base();?>/components/com_miniorange_saml/assets/images/phone.svg" width="27" height="27"  alt="Phone Image"> 
                            </div>
                            <div class="mo_boot_col-sm-10">
                                <p><strong><?php echo JText::_('COM_MINIORANGE_SAML_SUPPORT_NOTE'); ?></strong></p><br>
                            </div>
                            
                        </div>
                    </div>
                    <p><?php echo JText::_('COM_MINIORANGE_SAML_SUPPORT_DESC'); ?></p>
                    <div class="mo_boot_row mo_boot_text-center">
                        <div class="mo_boot_col-sm-12 mo_boot_mt-3">
                            <input type="email" class="mo_saml_table_textbox mo_boot_form-control mo_saml_proxy_setup" name="query_email" value="<?php echo $admin_email; ?>" placeholder="<?php echo JText::_('COM_MINIORANGE_SAML_ENTER_EMAIL'); ?>" required />
                        </div>
                        <div class="mo_boot_col-sm-12 mo_boot_mt-3">
                            <input type="text" class="mo_saml_table_textbox mo_boot_form-control mo_saml_proxy_setup" name="query_phone" pattern="[\+]\d{11,14}|[\+]\d{1,4}([\s]{0,1})(\d{0}|\d{9,10})" value="<?php echo $admin_phone; ?>" placeholder="<?php echo JText::_('COM_MINIORANGE_SAML_PHONE_PLACEHOLDER'); ?>"/>
                        </div>
                        <div class="mo_boot_col-sm-12 mo_boot_mt-3">
                            <textarea  name="mo_saml_query_support" class="mo_boot_form-text-control mo_saml_proxy_setup" cols="52" rows="7" required placeholder="<?php echo JText::_('COM_MINIORANGE_SAML_WRITE_QUERY'); ?>"></textarea>
                        </div>
                    </div>
                    <div class="mo_boot_row mo_boot_text-center mo_boot_mt-3">
                        <div class="mo_boot_col-sm-12">
                            <input type="hidden" name="option1" value="mo_saml_login_send_query"/>
                            <input type="submit" name="send_query" value="<?php echo JText::_('COM_MINIORANGE_SAML_SUBMIT_QUERY'); ?>" class="mo_boot_btn mo_boot_btn-success" />
                        </div>
                    </div><hr>
                    <div class="mo_boot_row">
                        <div class="mo_boot_col-sm-12">
                            <p><br><?php echo JText::_('COM_MINIORANGE_SAML_SUPPORT_EMAIL'); ?> <a style="word-wrap:break-word!important;" href="mailto:joomlasupport@xecurify.com"> joomlasupport@xecurify.com</a> </p>
                        </div>
                    </div>
			    </form>
			</div>
		</div>
	</div>
    <?php
}


function mo_saml_advertise(){
	?>
	<div id="sp_advertise" class="">
		<div class="mo_boot_row mo_boot_p-3 mo_tab_border">
			<div class="mo_boot_col-sm-12">
				<div class="mo_boot_row">
                    <div class="mo_boot_col-sm-2">
                        <img src="<?php echo JUri::base();?>/components/com_miniorange_saml/assets/images/miniorange_i.ico" alt="miniorange">  
                    </div>
                    <div class="mo_boot_col-sm-10">
                        <h4><?php echo JText::_('COM_MINIORANGE_SAML_SCIM_ADD'); ?></h4>
                    </div>
				</div><hr>
			</div>
			<div class="mo_boot_col-sm-12">
               <div class="mo_boot_px-3  mo_boot_text-center">
                     <img src="<?php echo JUri::base();?>/components/com_miniorange_saml/assets/images/scim-icon.png" width="100" height="100" alt="SCIM">
                </div>
               <p><br><br>
                    <?php echo JText::_('COM_MINIORANGE_SAML_SICM_INFO'); ?>
               </P>
               <div class="mo_boot_row mo_boot_text-center mo_boot_mt-5">
                   <div class="mo_boot_col-sm-12">
                        <input type="button" onclick="window.open('https://prod-marketing-site.s3.amazonaws.com/plugins/joomla/scim-user-provisioning-for-joomla.zip')" target="_blank" value="<?php echo JText::_('COM_MINIORANGE_SAML_DOWNLOAD'); ?>"   class="mo_boot_btn mo_boot_btn-saml" />
                        <input type="button" onclick="window.open('https://plugins.miniorange.com/joomla-scim-user-provisioning')" target="_blank" value="<?php echo JText::_('COM_MINIORANGE_SAML_KNOW_MORE'); ?>"   class="mo_boot_btn mo_boot_btn-success mo_boot_ml-1" />
                    </div>
               </div>
			</div>
		</div>
	</div>
<?php
}

function mo_saml_adv_pagerestriction(){
    ?>
    <div id="sp_advertise" class="">
        <div class="mo_boot_row mo_boot_p-3 mo_tab_border">
            <div class="mo_boot_col-sm-12">
                <div class="mo_boot_row">
                    <div class="mo_boot_col-sm-2">
                        <img src="<?php echo JUri::base();?>/components/com_miniorange_saml/assets/images/miniorange_i.ico" alt="miniorange">  
                    </div>
                    <div class="mo_boot_col-sm-10">
                        <h4><?php echo JText::_('COM_MINIORANGE_SAML_PAGE_RESTRICTION'); ?></h4>
                    </div>
                </div><hr>
            </div>
            <div class="mo_boot_col-sm-12 ">
                <div class="mo_boot_px-3  mo_boot_text-center">
                         <img src="<?php echo JUri::base();?>/components/com_miniorange_saml/assets/images/session-management-addon.webp" alt="Session Management" width="150"  height="150" >
                </div>
                <p><br>
                    <?php echo JText::_('COM_MINIORANGE_SAML_PAGE_RESTRICTION_INFO'); ?>
                </P>
                <div class="mo_boot_row mo_boot_text-center mo_boot_mt-5">
                    <div class="mo_boot_col-sm-12">
                        <input type="button" onclick="window.open('https://plugins.miniorange.com/page-and-article-restriction-for-joomla')" target="_blank" value="<?php echo JText::_('COM_MINIORANGE_SAML_KNOW_MORE'); ?>" class="mo_boot_btn mo_boot_btn-success" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}

function mo_saml_adv_net(){
    ?>
    <div id="sp_advertise" class="">
        <div class="mo_boot_row mo_boot_p-3 mo_tab_border" >
            <div class="mo_boot_col-sm-12">
                <div class="mo_boot_row">
                    <div class="mo_boot_col-sm-2">
                        <img src="<?php echo JUri::base();?>/components/com_miniorange_saml/assets/images/miniorange_i.ico" alt="miniorange">  
                    </div>
                    <div class="mo_boot_col-sm-10">
                        <h4><?php echo JText::_('COM_MINIORANGE_SAML_WEB_SECURITY'); ?></h4>
                    </div>
                </div><hr>
            </div>
            <div class="mo_boot_col-sm-12 ">
                <div class="mo_boot_px-3  mo_boot_text-center">
                    <img src="<?php echo JUri::base();?>/components/com_miniorange_saml/assets/images/network.webp" alt="Web Security">
                </div><p><?php echo JText::_('COM_MINIORANGE_SAML_WEB_SECURITY_INFO'); ?></P>
                <div class="mo_boot_row mo_boot_text-center mo_boot_mt-5">
                    <div class="mo_boot_col-sm-12">
                        <input type="button" onclick="window.open('https://prod-marketing-site.s3.amazonaws.com/plugins/joomla/miniorange_joomla_network_security.zip')" target="_blank" value="<?php echo JText::_('COM_MINIORANGE_SAML_DOWNLOAD'); ?>" class="mo_boot_btn mo_boot_btn-saml" />
                        <input type="button" onclick="window.open('https://plugins.miniorange.com/joomla-network-security')" target="_blank" value="<?php echo JText::_('COM_MINIORANGE_SAML_KNOW_MORE'); ?>"  class="mo_boot_btn mo_boot_btn-success mo_boot_ml-1" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}

function mo_saml_adv_loginaudit(){
    ?>
    <div id="sp_advertise" class="">
        <div class="mo_boot_row mo_boot_p-3 mo_tab_border">
            <div class="mo_boot_col-sm-12">
                <div class="mo_boot_row">
                    <div class="mo_boot_col-sm-2">
                        <img src="<?php echo JUri::base();?>/components/com_miniorange_saml/assets/images/miniorange_i.ico" alt="miniorange">  
                    </div>
                    <div class="mo_boot_col-sm-10">
                        <h4><?php echo JText::_('COM_MINIORANGE_SAML_LOGIN_AUDIT'); ?></h4>
                    </div>
                </div><hr>
                </div>
                <div class="mo_boot_col-sm-12 ">
                    <p><br><?php echo JText::_('COM_MINIORANGE_SAML_LOGIN_AUDIT_INFO'); ?></P>
                   <div class="mo_boot_row mo_boot_text-center mo_boot_mt-4">
                       <div class="mo_boot_col-sm-12">
                            <input type="button" onclick="window.open('https://plugins.miniorange.com/joomla-login-audit-login-activity-report')" target="_blank" value="<?php echo JText::_('COM_MINIORANGE_SAML_KNOW_MORE'); ?>" class="mo_boot_btn mo_boot_btn-success" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
}

function mo_saml_adv_idp(){
    ?>
    <div id="sp_advertise" class="">
        <div class="mo_boot_row mo_boot_p-3 mo_tab_border">
            <div class="mo_boot_col-sm-12">
                <div class="mo_boot_row">
                    <div class="mo_boot_col-sm-2">
                        <img src="<?php echo JUri::base();?>/components/com_miniorange_saml/assets/images/miniorange_i.ico" alt="miniorange">  
                    </div>
                    <div class="mo_boot_col-sm-10">
                        <h4><?php echo JText::_('COM_MINIORANGE_SAML_MEDIA_RESTRICTION'); ?></h4>
                    </div>
                </div><hr>
                </div>
                <div class="mo_boot_col-sm-12 ">
                   <div class="mo_boot_px-3  mo_boot_text-center">
                       <img src="<?php echo JUri::base();?>/components/com_miniorange_saml/assets/images/login-audit-addon.webp" alt="Login Audit"  width="150"  height="150" >
                    </div>
                   <p><br><br>
                        <?php echo JText::_('COM_MINIORANGE_SAML_MEDIA_RESTRICTION_INFO'); ?>
                   </P>
                   <div class="mo_boot_row mo_boot_text-center mo_boot_mt-5">
                       <div class="mo_boot_col-sm-12">
                            <input type="button" onclick="window.open('https://plugins.miniorange.com/media-restriction-in-joomla')" target="_blank" value="<?php echo JText::_('COM_MINIORANGE_SAML_KNOW_MORE'); ?>" class="mo_boot_btn mo_boot_btn-success" />
                        </div>
                   </div>
                </div>
            </div>
        </div>
    <?php
}
?>