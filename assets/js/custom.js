$(document).ready(function() {
    console.log("Document ready");

    // Incrémenter la quantité
    $(document).on('click', '.increment-btn', function (e) {
        e.preventDefault();

        var qty = $(this).closest('.product-data').find('.input-qte');
        var currentVal = parseInt(qty.val());

        if (!isNaN(currentVal)) {
            qty.val(currentVal + 1);
        } else {
            qty.val(1);
        }
    });

    // Décrémenter la quantité
    $(document).on('click', '.decrement-btn', function (e) {
        e.preventDefault();

        var qty = $(this).closest('.product-data').find('.input-qte');
        var currentVal = parseInt(qty.val());

        if (!isNaN(currentVal) && currentVal > 1) {
            qty.val(currentVal - 1);
        } else {
            qty.val(1);
        }
    });

    // Ajouter au panier
    $(document).on('click', '.addToCartBtn', function (e) {

        e.preventDefault();
        console.log("Add to cart button clicked");

        var qte = $(this).closest('.container').find('.input-qte').val();
        var prod_id = $(this).val();
        console.log("Product ID: " + prod_id);
        console.log("Quantity: " + qte);

        $.ajax({
            method: "POST",
            url: "functions/handlecart.php",
            data: {
                "prod_id": prod_id,
                "prod_qte": qte,
                "scope": "add",
            },
            success: function(response) {
                console.log("Données envoyées : ", {
                    "prod_id": prod_id,
                    "prod_qte": qte,
                    "scope": "add",
                });
                console.log("AJAX execute avec success: " + response);
                if (response == 201) {
                    alertify.success('Produit ajoute au panier');
                } else if (response == "existing") {
                    alertify.success('Le produit est deja ajoute au panier');
                } else if (response == 401) {
                    alertify.error('Connectez vous pour continuer');
                } else if (response == 500) {
                    alertify.error("Quelque chose c'est mal passe");
                }
            },
            error: function(xhr, status, error) {
                console.log("AJAX error: " + error);
            }
        });
    });

    $(document).on('click', '.updateQte', function() {
        var qte = $(this).closest('.product-data').find('.input-qte').val();
        var prod_id = $(this).closest('.product-data').find('.prodId').val();

        $.ajax({
            method: "POST",
            url: "functions/handlecart.php",
            data: {
                "prod_id": prod_id,
                "prod_qte": qte,
                "scope": "update",
            },
            success: function (response) {
                // alert(response);
            }
        });
    });

    $(document).on('click', '.deleteBtn', function () {
        var card_id = $(this).val();
        // alert(card_id);
        $.ajax({
            method: "POST",
            url: "functions/handlecart.php",
            data: {
                "card_id": card_id,
                "scope": "delete",
            },
            success: function (response) {
                if(response == 200){
                    alertify.success("Produit retirer du panier avec success");
                    // $('#mycart').load(location.href + "#mycart");
                    $.ajax({
                        method: "POST",
                        url: "cart.php",
                        data: {
                            "reload_cart": true,
                        },
                        success: function (data) {
                            $("#mycart").html($(data).find("#mycart").html());
                        }
                    });
                } else if (reponse == 500){
                    alertify.success(response);
                }
            }
        });
    });
});