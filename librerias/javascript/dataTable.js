/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {   
    alert("paso");
    $('#example').DataTable({
        "pagingType": "full_numbers",
         "lengthMenu": [ 10, 25, 50, 75, 100 ]
    });
});
