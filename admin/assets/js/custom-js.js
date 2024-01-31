$(document).ready(function () {
  alertify.set("notifier", "position", "top-right");
  $(document).on("click", ".increment", function () {
    var $quantityInput = $(this).closest(".qtyBox").find(".qty");
    var productId = $(this).closest(".qtyBox").find(".prodId").val();
    var currentValue = parseInt($quantityInput.val());
    if (!isNaN(currentValue)) {
      var qtyval = currentValue + 1;
      $quantityInput.val(qtyval);
      quantityIncDec(productId, qtyval);
    }
  });

  $(document).on("click", ".decrement", function () {
    var $quantityInput = $(this).closest(".qtyBox").find(".qty");
    var productId = $(this).closest(".qtyBox").find(".prodId").val();
    var currentValue = parseInt($quantityInput.val());
    if (!isNaN(currentValue) && currentValue > 1) {
      var qtyval = currentValue - 1;
      $quantityInput.val(qtyval);
      quantityIncDec(productId, qtyval);
    }
  });

  function quantityIncDec(prodId, qty) {
    $.ajax({
      type: "POST",
      url: "orders-code.php",
      data: {
        productIncDec: true,
        product_id: prodId,
        quantity: qty,
      },
      success: function (response) {
        var res = JSON.parse(response);
        if (res.status == 200) {
          $("#productArea").load(" #productContent");
          alertify.success(res.message);
        } else {
          $("#productArea").load(" #productContent");
          alertify.error(res.message);
        }
      },
    });
  }

  $(document).on("click", ".proceedToPlace", function () {
    var cphone = $("#cphone").val();
    var payment_mode = $("#payment_mode").val();
    if (payment_mode == "") {
      swal("Select Payment Mode", "The Payment Mode is required", "warning");
      return false;
    }
    if (cphone == "" || isNaN(cphone)) {
      swal(
        "Phone Number Error",
        "The phone number is required and must be valid",
        "warning"
      );
      return false;
    }
    $.ajax({
      type: "POST",
      url: "orders-code.php",
      data: {
        proceedToPlaceBtn: true,
        cphone: cphone,
        payment_mode: payment_mode,
      },
      success: function (response) {
        var res = JSON.parse(response);
        if (res.status == 200) {
          window.location.href = "order-summary.php";
        } else if (res.status == 404) {
          swal("error", res.message, res.status_type, {
            buttons: {
              catch: {
                text: "Add Customer",
                value: "catch",
              },
              cancel: "cancel",
            },
          }).then((value) => {
            switch (value) {
              case "catch":
                $("#c_phone").val(cphone);
                $("#addCustomerModal").modal("show");
                // console.log("pop the customer add modal");
                break;
              default:
            }
          });
        } else {
          swal(res.message, res.message, res.status_type);
        }
      },
    });
  });

  $(document).on("click", ".saveCustomer", function () {
    var c_name = $("#c_name").val();
    var c_phone = $("#c_phone").val();
    var c_email = $("#c_email").val();
    if (c_name != "" && c_phone != "") {
      if ($.isNumeric(c_phone)) {
        var data = {
          saveCustomerBtn: true,
          name: c_name,
          phone: c_phone,
          email: c_email,
        };
        $.ajax({
          type: "POST",
          url: "orders-code.php",
          data: data,
          success: function (response) {
            res = JSON.parse(response);
            if (res.status == 200) {
              swal(res.message, res.message, res.status_type);
              $("#addCustomerModal").modal("hide");
            } else if (res.status == 404) {
              swal(res.message, res.message, res.status_type);
            } else {
              swal(res.message, res.message, res.status_type);
            }
          },
        });
      } else {
        swal(
          "the phone number",
          "The phone number provided is nut valid",
          "warning"
        );
      }
    } else {
      swal("provide both name and phone number", "", "warning");
    }
  });

  $(document).on("click", "#saveOrder", function () {
    $.ajax({
      type: "POST",
      url: "orders-code.php",
      data: {
        saveOrder: true,
      },
      success: function (response) {
        var res = JSON.parse(response);
        if (res.status == 200) {
          swal(res.message, res.message, res.status_type);
          $("#orderPlaceSuccessMessage").text(res.message);
          $("#orderSuccessModal").modal("show");
        } else {
          swal(res.message, res.message, res.status_type);
        }
      },
    });
  });
});

function printMyBillingArea() {
  var divContents = document.getElementById("myBillingArea").innerHTML;
  var a = window.open("", "");
  a.document.write("<html><head><title>POS system</title>");
  a.document.write(
    "<style>.summary-table {width: 100%;margin-bottom: 20px;}.first-summary-part {text-align: center;margin: 2px;padding: 0;}.first-summary-part h4 {font-size: 23px;line-height: 30px;}.first-summary-part p {font-size: 16px;line-height: 24px;}.second-summary-part h5{font-size: 20px;line-height: 30px;margin: 0px;padding: 0;}.second-summary-part p {font-size: 16px;line-height: 20px;margin: 0px;padding: 0;}.secondTable {width: 100%;}.secondTable th {border-bottom: 1px solid #ccc;align-items: start;}.secondTable .tr td {border-bottom: 1px solid #ccc;}.grand-total {font-weight: bold;}</style>"
  );
  a.document.write("</head><body style='font-family:fangsong;'>");
  a.document.write(divContents);
  a.document.write("</body></html>");
  a.document.close();
  a.print();
}

window.jsPDF = window.jspdf.jsPDF;
var docPdf = new jsPDF();

function downloadPdf(invoiceNo) {
  var elementHtml = document.querySelector("#myBillingArea");
  docPdf.html(elementHtml, {
    callback: function () {
      docPdf.save(invoiceNo + ".pdf");
    },
    x: 15,
    y: 15,
    width: 170,
    windowWidth: 650,
  });
}
