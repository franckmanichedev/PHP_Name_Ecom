                <footer class="footer">
                    <div class="container-fluid">
                        <nav>
                            <ul class="footer-menu">
                                <li>
                                    <a href="#">
                                        Accueil
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        Notre equipe
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        A propos
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        Site web
                                    </a>
                                </li>
                            </ul>
                            <p class="copyright text-center">
                                © copyright 
                                <script>
                                    document.write(new Date().getFullYear())
                                </script>
                                by
                                <a href="http://www.creative-tim.com">skills for modernity</a>, all right reserved 
                            </p>
                        </nav>
                    </div>
                </footer>
            </div>
        </div>

        <script src="assets/js/jquery-3.7.1.min.js" type="text/javascript"></script>
        <script src="assets/js/popper.min.js" type="text/javascript"></script>
        <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="assets/js/bootstrap.bundle.min.js" type="text/javascript"></script>
        <script src="assets/js/perfect-scrollbar.min.js"></script>

        <!-- SweetAlert JS -->
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        
        <!-- Custom JS -->
        <script src="assets/js/custom.js" type="text/javascript"></script>
        
        <!-- ALERTIFY JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js"></script>
        <script>
            
            alertify.set('notifier','position', 'top-right');
            
            <?php 
                if(isset($_SESSION['message'])){
                    ?>
                        alertify.success('<?= addslashes($_SESSION['message']); ?>');
                    <?php
                    unset($_SESSION['message']);
                }
            ?>

        </script>
    </body>
</html>