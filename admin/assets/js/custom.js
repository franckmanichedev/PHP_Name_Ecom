// $(document).ready(function() {
//     console.log("Document ready");
//     $(document).on('click', 'delete_product_btn', function(e){
//         e.preventDefault();
//         console.log("Delete button clicked");

//         var id = $(this).val();
//         console.log("Product ID: " + id);

//         swal({
//             title: "Etes vous sur ?",
//             text: "Cliquez sur ok pour le supprimer definitivement.",
//             icon: "warning",
//             buttons: true,
//             dangerMode: true,
//         })
//         .then((willDelete) => {
//             if (willDelete) {
//                 console.log("Will delete confirmed");

//                 $.ajax({
//                     method: "POST",
//                     url: "code.php",
//                     data: {
//                         'product_id': id,
//                         'delete_product_btn': true,
//                     },
//                     success: function(response) {
//                         console.log("AJAX success response: " + response);

//                         if (response.trim() == 200) {
//                             console.log("Product deleted successfully");
//                             swal("Supprimer !", "Product supprimer avec success !", "success")
//                             // $('#product_table').load(location.href + "#product_table");
//                             .then((value) => {
//                                 // Ajoutez un délai avant de recharger la page
//                                 setTimeout(function() {
//                                     location.reload();
//                                 }, 1000); // Délai de 1 seconde
//                             });
//                         } else if (response.trim() == 500) {
//                             console.log("Error deleting product");
//                             swal("Erreur !", "Erreur lors du chargement du fichier !", "error");
//                         }
//                     },
//                     error: function(xhr, status, error) {
//                         console.log("AJAX error: " + error);
//                     }
//                 });
//             }
//         });
//     }); 

//     $(document).on('click', 'delete_category_btn', function(e){
//         e.preventDefault();
//         console.log("Delete button clicked");

//         var id = $(this).val();
//         console.log("Category ID: " + id);

//         swal({
//             title: "Etes vous sur ?",
//             text: "Cliquez sur ok pour le supprimer definitivement.",
//             icon: "warning",
//             buttons: true,
//             dangerMode: true,
//         })
//         .then((willDelete) => {
//             if (willDelete) {
//                 console.log("Will delete confirmed");

//                 $.ajax({
//                     method: "POST",
//                     url: "code.php",
//                     data: {
//                         'category_id': id,
//                         'delete_category_btn': true,
//                     },
//                     success: function(response) {
//                         console.log("AJAX success response: " + response);

//                         if (response.trim() == 200) {
//                             console.log("Categorie deleted successfully");
//                             swal("Supprimer !", "Categorie supprimer avec success !", "success")
//                             // $('#category_table').load(location.href + "#category_table");
//                             .then((value) => {
//                                 // Ajoutez un délai avant de recharger la page
//                                 setTimeout(function() {
//                                     location.reload();
//                                 }, 1000); // Délai de 1 seconde
//                             });
//                         } else if (response.trim() == 500) {
//                             console.log("Error deleting product");
//                             swal("Erreur !", "Erreur lors du chargement du fichier !", "error");
//                         }
//                     },
//                     error: function(xhr, status, error) {
//                         console.log("AJAX error: " + error);
//                     }
//                 });
//             }
//         });
//     }); 
// });