<?php
	echo '<h1>'.MANAGE_MYGROUP.'</h1>';
    include(DIR_FSROOT.'/html/small_admin/mygroup/w_group.php');
    include(DIR_FSROOT.'/html/small_admin/mygroup/r_group_wh_id.php');
    include(DIR_FSROOT.'/html/small_admin/mygroup/r_group.php');
    include(DIR_FSROOT.'/html/small_admin/mygroup/d_group.php');
    echo '<div class="clearfix"></div>';

    if (isset($_GET['f_id_auth_group'])) {
        echo '<a href="'.removeqsvar($cur_url,'f_id_auth_group').'"><button type="button" class="btn btn-primary">'.ADD.' '.GROUP.'</button></a>';
    }
    echo '<div class="clearfix"></div>';
    $perm_grp = new PERMS();
    $f_id_auth_group=intval(GET('f_id_auth_group'));
    if (($f_id_auth_group && $perm_grp->auth_user_group($f_id_auth_group,true)) || !$f_id_auth_group) {
        echo '<fieldset>';
        if (isset($cur_group)) {
            echo '<legend>'.$cur_group->group.'</legend>';
        }
        echo '<fieldset>';
        if (isset($_GET['f_id_auth_group'])) {
            echo '<legend>'.EDIT.'</legend>';
        }
        else {
            echo '<legend>'.ADD.'</legend>';
        }

        include(DIR_FSROOT.'/html/small_admin/mygroup/f_group.php');
        echo '</fieldset>';

        if (isset($_GET['f_id_auth_group'])) {
            echo '<fieldset>';
            echo '<legend>'.USERS.'</legend>';
            include(DIR_FSROOT.'/html/small_admin/mygroup_user/w_group_user.php');
            include(DIR_FSROOT.'/html/small_admin/mygroup_user/e_group_user.php');
            include(DIR_FSROOT.'/html/small_admin/mygroup_user/r_group_user_wh_id.php');
            include(DIR_FSROOT.'/html/small_admin/mygroup_user/r_group_user.php');
            include(DIR_FSROOT.'/html/small_admin/mygroup_user/d_group_user.php');
            echo '<div class="clearfix"></div>';

            if (isset($_GET['f_id_auth_user'])) {
                echo '<a href="'.removeqsvar($cur_url,'f_id_auth_user').'"><button type="button" class="btn btn-primary">'.ADD.' '.USER.'</button></a>';
            }
            echo '<div class="clearfix"></div>';
            if (isset($_GET['f_id_auth_user'])) {
                echo '<strong>'.DEL.'</strong>';
			} else {
                echo '<strong>'.ADD.'</strong>';
            }
            include(DIR_FSROOT.'/html/small_admin/mygroup_user/f_group_user.php');
            echo '</fieldset>';
        }
        echo '</fieldset>';
    }
    echo '<div class="clearfix"></div>';
?>
