<?php // no direct access
defined('_JEXEC') or die('Restricted access');
require_once JPATH_SITE . '/components/com_users/helpers/route.php';

JHtml::_('behavior.keepalive');
JHtml::_('bootstrap.tooltip');
?>
<?php if(JPluginHelper::isEnabled('authentication', 'openid')) :
        $lang->load( 'plg_authentication_openid', JPATH_ADMINISTRATOR );
        $langScript =   'var JLanguage = {};'.
                        ' JLanguage.WHAT_IS_OPENID = \''.JText::_( 'WHAT_IS_OPENID' ).'\';'.
                        ' JLanguage.LOGIN_WITH_OPENID = \''.JText::_( 'LOGIN_WITH_OPENID' ).'\';'.
                        ' JLanguage.NORMAL_LOGIN = \''.JText::_( 'NORMAL_LOGIN' ).'\';'.
                        ' var modlogin = 1;';
        $document = &JFactory::getDocument();
        $document->addScriptDeclaration( $langScript );
        JHTML::_('script', 'openid.js');
endif; ?>
<a id="linkformlogin-<?php echo $module->id; ?>" href="#">Acceso</a>
<script type="text/javascript">
    
    jQuery(document).ready(function () {
        
        function ocultarFormLogin () {
            jQuery('#formlogin-<?php echo $module->id; ?>').fadeOut();
            jQuery(documento).off('click', ocultarFormLogin);
        }
        
        jQuery('#linkformlogin-<?php echo $module->id; ?>').click(function (e) {

            e.preventDefault();            
            e.stopPropagation();
            jQuery('#formlogin-<?php echo $module->id; ?>').fadeIn();
            jQuery('#formlogin-<?php echo $module->id; ?> [data-toggle="tooltip"]').tooltip({container: 'body'});

            jQuery(document).click(ocultarFormLogin);
        });
        
        jQuery('#formlogin-<?php echo $module->id; ?>').click(function (e) {
            e.stopPropagation();
        });
        
    });
    
</script>
<form class="formlogin" action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="formlogin-<?php echo $module->id; ?>">
    <?php if ($params->get('pretext')) : ?>
        <div class="pretext">
            <p><?php echo $params->get('pretext'); ?></p>
        </div>
    <?php endif; ?>
    <div class="form-group">
        <label for="modlgn-username"><?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?></label>
        <input id="modlgn-username" type="text" name="username" class="form-control" tabindex="0" size="18" placeholder="<?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?>" />
    </div>
    <div class="form-group">
        <label for="modlgn-passwd"><?php echo JText::_('JGLOBAL_PASSWORD') ?></label>
        <input id="modlgn-passwd" type="password" name="password" class="form-control" tabindex="0" size="18" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD') ?>" />
    </div>
    <?php if (count($twofactormethods) > 1): ?>
        <div class="form-group">
            <label for="modlgn-secretkey"><?php echo JText::_('JGLOBAL_SECRETKEY') ?></label>
            <div class="input-group">
                <input id="modlgn-secretkey" autocomplete="off" type="text" name="secretkey" class="form-control" tabindex="0" size="18" placeholder="<?php echo JText::_('JGLOBAL_SECRETKEY') ?>" />
                <span class="input-group-addon" data-toggle="tooltip" data-placement="bottom" title="<?php echo JText::_('JGLOBAL_SECRETKEY_HELP'); ?>">
                    <span class="glyphicon glyphicon-info-sign"></span>
                </span>
            </div>
        </div>
    <?php endif; ?>
    <?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
        <div id="form-login-remember" class="checkbox">
            <label>
                <input id="modlgn-remember" type="checkbox" name="remember" value="yes"/>
                <?php echo JText::_('MOD_LOGIN_REMEMBER_ME') ?>
            </label>
        </div>
    <?php endif; ?>
    <div id="form-login-submit">
        <button type="submit" tabindex="0" name="Submit" class="btn btn-default"><?php echo JText::_('JLOGIN') ?></button>
    </div>
    <?php
    $usersConfig = JComponentHelper::getParams('com_users'); ?>
    <ul class="unstyled">
    <?php if ($usersConfig->get('allowUserRegistration')) : ?>
        <li>
            <a href="<?php echo JRoute::_('index.php?option=com_users&view=registration&Itemid=' . UsersHelperRoute::getRegistrationRoute()); ?>">
            <?php echo JText::_('MOD_LOGIN_REGISTER'); ?> <span class="icon-arrow-right"></span></a>
        </li>
    <?php endif; ?>
        <li>
            <a href="<?php echo JRoute::_('index.php?option=com_users&view=remind&Itemid=' . UsersHelperRoute::getRemindRoute()); ?>">
            <?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_USERNAME'); ?></a>
        </li>
        <li>
            <a href="<?php echo JRoute::_('index.php?option=com_users&view=reset&Itemid=' . UsersHelperRoute::getResetRoute()); ?>">
            <?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_PASSWORD'); ?></a>
        </li>
    </ul>
    <input type="hidden" name="option" value="com_users" />
    <input type="hidden" name="task" value="user.login" />
    <input type="hidden" name="return" value="<?php echo $return; ?>" />
    <?php echo JHtml::_('form.token'); ?>
    <?php if ($params->get('posttext')) : ?>
        <div class="posttext">
            <p><?php echo $params->get('posttext'); ?></p>
        </div>
    <?php endif; ?>
</form>