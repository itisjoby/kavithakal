<script src="{{asset('/js/public_dashboard.js')}}"></script>
<?php
$success_msg = '';
$failed_msg = '';
if (isset($_SESSION['site_messages']['status'])) {
    if ($_SESSION['site_messages']['status'] == 1) {
        $success_msg = $_SESSION['site_messages']['msg'];
    } else {
        $failed_msg = $_SESSION['site_messages']['msg'];
    }
}
$_SESSION = [];
echo '<script>let success_msg="' . $success_msg . '"</script>';
echo '<script>let failed_msg="' . $failed_msg . '"</script>';
?>
<script>
    alertify.set('notifier', 'position', 'top-right');
    if (success_msg !== '') {
        alertify.success(success_msg);
    }
    if (failed_msg !== '') {
        alertify.error(failed_msg);
    }
</script>
<div class="footer_container">
    <span class="text-muted text-center">Copyright © <?php echo date('Y'); ?></span>
</div>