
    <script src="assets/js/jquery.3.7.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/owl.carousel.min.js"></script>
    <script src="../assets/js/owl.carousel.js"></script>

    <!-- ALERTIFY JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js"></script>

    
    <!-- CUSTOM FILES -->
    <script src="assets/js/custom.js" type="text/javascript"></script>

    <script>
        <?php 
            if(isset($_SESSION['message'])){
                ?>
                    alertify.set('notifier','position', 'top-right');
                    alertify.success('<?= addslashes($_SESSION['message']); ?>');
                <?php
                unset($_SESSION['message']);
            }
        ?>
    </script>
</body>
</html>