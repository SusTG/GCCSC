<?php

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
?>
<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form" class="navbar-form">
<?php if ($params->get('greeting')) : ?>
    <?php if ($params->get('name') == 0) : {
        echo JText::sprintf('MOD_LOGIN_HINAME', htmlspecialchars($user->get('name')));
    } else : {
        echo JText::sprintf('MOD_LOGIN_HINAME', htmlspecialchars($user->get('username')));
    } endif; ?>
    <?php endif; ?>
    <button type="submit" name="Submit" class="btn btn-primary">
        <span class="glyphicon glyphicon-log-out"></span>
    </button>
    <input type="hidden" name="option" value="com_users" />
    <input type="hidden" name="task" value="user.logout" />
    <input type="hidden" name="return" value="<?php echo $return; ?>" />
    <?php echo JHtml::_('form.token'); ?>
</form>