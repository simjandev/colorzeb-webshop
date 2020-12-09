<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="https://colorzebdesign.hu/css/bootstrap-email.css">
    <style>
        .table.table-bordered td,
        .table.table-bordered tr,
        .table.table-bordered th {
            border-color: rgb(210, 210, 210);
        }

        .table.table-bordered th {
            background-color: rgb(225, 225, 225);
            text-align: center;
        }

        .table.table-bordered {
            border-color: rgb(210, 210, 210);
            background-color: rgb(252, 252, 252);
        }

        @media only screen and (max-width: 800px) {
            .order-text-box,
            #signature,
            #order-products,
            #order-customer-data,
            #order-customer-shipping-data,
            #order-customer-billing-data,
            #order-sum {
                width: calc(100% - 20px) !important;
            }

            #content, #signature, #footer-info {
                font-size: 14px !important;
            }

            #content {
                padding: 2px !important;
            }

            #footer-info span{
                color: white !important;
            }
        }

        @media only screen and (max-width: 400px) {
            #order-products tr,
            #order-products th,
            #order-products td {
                box-sizing: border-box;
                height: 66px !important;
                line-height: 66px !important;
            }

            .order-text-box,
            #order-products,
            #order-customer-data,
            #order-customer-shipping-data,
            #order-customer-billing-data,
            #order-sum {
                width: calc(100% - 6px) !important;
            }

            #order-products .product-image {
                height: 34px !important;
                width: 34px !important;
            }

            #order-products td:nth-child(1) {
                width: 34px !important;
                padding-top: 8px !important;
            }

            #order-products td:nth-child(2) {
                padding: 3px !important;
                line-height: 20px !important;
            }

            #order-products td:nth-child(4) {
                width: 60px !important;
            }

            #content, #signature, #footer-info {
                font-size: 12px !important;
                padding: 1px !important;
            }

            #signature {
                padding-top: 4px;
            }

            #footer-info span{
                color: white !important;
            }
        }
    </style>
</head>
<body id="#body">
    {!! $header ?? '' !!}
    <div id="content">
        {!! $slot !!}
    </div>
    <div id="signature" class="order-text-box">
        Üdvözlettel,<br>
        Simonyi Zsuzsanna
    </div>
    {!! $footer ?? '' !!}
</body>
</html>
