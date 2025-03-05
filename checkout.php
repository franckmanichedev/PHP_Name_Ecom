<?php
    session_start();
    include_once("functions/usersfunctions.php");
    include("includes/header.php");

    include("authentificate.php");

    $cartItems = getCartItems();
    if(mysqli_num_rows($cartItems) == 0){
        header('Location: index.php');
    }
?>

    <div class="py-3 bg-primary">
        <div class="container">
            <h6 class="text-white">
                <a href="index.php" class="text-white redirection-link">
                    Home /
                </a>
                <a href="./checkout.php" class="text-white redirection-link">
                    Checkout
                </a>
            </h6>
        </div>
    </div>

    <div class="py-5">
        <div class="container">
            <div class="card">
                <form class="row" action="functions/place-order.php" method="POST">
                    <div class="card-body shadow">
                        <div class="row justify-content-center">
                            <div class="col-md-7">
                                <h5>Vos coordonnees</h5>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-6 mt-3">
                                        <label  class="form-label">Nom</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Entrer votre nom complet">
                                        <small class="text-danger name"></small>
                                    </div>
                                    <div class="col-lg-6 mt-3">
                                        <label  class="form-label">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" placeholder="Entrer votre email">
                                    </div>
                                    <div class="col-lg-6 mt-3">
                                        <label class="form-label">Telephone</label>
                                        <input type="text" name="phone" id="phone" class="form-control" id="inputPassword4" placeholder="Entrer votre numero de telephone">
                                    </div>
                                    <div class="col-lg-6 mt-3">
                                        <label  class="form-label">Code pin</label>
                                        <input type="text" name="pincode" id="pincode" class="form-control"  placeholder="Entrer votre code pin">
                                    </div>
                                    <div class="col-lg-12 mt-3">
                                        <label for="">Adresse</label>
                                        <textarea rows="5" name="address" id="address" placeholder="Entrer la description de categorie ici" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <h5>Autres details</h5>
                                <hr>
                                <?php 
                                    $items = getCartItems(); 

                                    $totalprice = 0;

                                    foreach ($items as $item){

                                        ?>
                                            <div class="card shadow-dark shadow-sm mb-3">
                                                <div class="row align-items-center p-1">
                                                    <div class="col-md-2">
                                                        <img src="uploads/<?= $item['image']?>" alt="<?= $item['image']?>" width="50px">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p><?= $item['name']?></p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p> Rs <?= $item['selling_price']?></p>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <p>x <?= $item['product_qte']?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php

                                        $totalprice += $item['selling_price'] * $item['product_qte'];
                                    }
                                ?>
                                <hr>
                                <div class="row">
                                    <p class="col-md-7">Prix total: </p>
                                    <h5 class="col-md-5">Rs <span class="fw-bold"><?= $totalprice ?></span></h5>
                                </div>
                                <div class="">
                                    <input type="hidden" name="payment_mode" value="COD">
                                    <button type="submit" name="place_order_btn" class="btn btn-primary w-100 p-2 fw-bold fs-5">Confirmer et acheter | COD</button>
                                    <!-- Integration d'un moyen de payement PayPal -->
                                    <div id="paypal-button-container" class="mt-2"></div>
                                    <p id="result-message"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php include("includes/footer.php") ?>

<!-- Integration du moyen de payment PayPal -->

    <script
        src="https://www.paypal.com/sdk/js?client-id=test&buyer-country=US&currency=USD&components=buttons&enable-funding=card&disable-funding=venmo,paylater"
        data-sdk-integration-source="developer-studio"
    >
    </script>
    <script>
        window.paypal
        .Buttons({

            onClick(){
                var name = $('#name').val();
                var email = $('#email').val();
                var phone = $('#phone').val();
                var pincode = $('#pincode').val();
                var address = $('#address').val();

                if(name.length == 0){
                    $('.name').text('*Le nom est obligatoire');
                } else {
                    $('.name').text('');
                }
                if(email.length == 0){
                    $('.email').text('*L\'email est obligatoire');
                } else {
                    $('.email').text('');
                }
                if(phone.length == 0){
                    $('.phone').text('*Le telephone est obligatoire');
                } else {
                    $('.phone').text('');
                }
                if(pincode.length == 0){
                    $('.pincode').text('*Le code pin est obligatoire');
                } else {
                    $('.pincode').text('');
                }
                if(address.length == 0){
                    $('.address').text('*L\'adresse est obligatoire');
                } else {
                    $('.address').text('');
                }
                if(name.length == 0 || email.length == 0 || phone.length == 0 || pincode.length == 0 || address.length == 0){
                    return false;
                } else {
                    return true;
                }
            },
            style: {
                shape: "rect",
                layout: "vertical",
                color: "gold",
                label: "paypal",
            },
            // message: {
            //     amount: 100,
            // } ,

            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [
                        {
                            amount: {
                                value: <?= $totalprice ?>
                            },
                        },
                    ],
                });
            } ,

            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    // // Show a success message to the buyer
                    // alert('Transaction completed by ' + details.payer.name.given_name);

                    // // OPTIONAL: Call your server to save the transaction
                    // return fetch('/paypal-transaction-complete', {
                    //     method: 'POST',
                    //     url: 'functions/place-order.php',
                    //     headers: {
                    //         'content-type': 'application/json'
                    //     },
                    //     body: JSON.stringify({
                    //         orderID: data.orderID
                    //     })
                    // });
                    
                    var name = $('#name').val();
                    var email = $('#email').val();
                    var phone = $('#phone').val();
                    var pincode = $('#pincode').val();
                    var address = $('#address').val();

                    var data = {
                        'name': name,
                        'email': email,
                        'phone': phone,
                        'pincode': pincode,
                        'address': address,
                        'payment_mode': Payer par PayPal,
                        'payment_id': data.orderID,
                        'place_order_btn': true,
                    }
                    $.ajax({
                        method: "POST",
                        url: "functions/place-order.php",
                        data: data,
                        success: function (response) {
                            if (response == 201){
                                alertify.success('Commande passe avec success');
                                window.location.href = "my-order.php";
                            } else {
                                console.log(reponse);
                            }
                        }
                    });
                });
            } ,
        })
        .render("#paypal-button-container"); 
    </script>