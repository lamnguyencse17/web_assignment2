<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta HTTP-EQUIV="Content-language" CONTENT="vi">
    <link rel="shortcut icon" href=\"https://theme.hstatic.net/1000075078/1000610097/14/favicon.png?v=620" type="image/png">
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>The Coffee House</title>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            let textPrice = jQuery("#price").text()
            const price = parseInt(textPrice.slice(0, textPrice.length-1))
            const name = jQuery("#name").text()
            jQuery("#purchase").click(function(){
            const quantity = parseInt(jQuery("#quantity").val());
            const url = new URL(window.location.href);
            const id = parseInt(url.searchParams.get("id"));
            const newItem = [id, quantity];
            let cart = localStorage.getItem("cart") ? JSON.parse(localStorage.getItem("cart")): [];
            let dict = localStorage.getItem("dict") ? JSON.parse(localStorage.getItem("dict")): [];
            if (dict.length > 0){
                let isAvailable = false;
                dict.forEach(function(item, i) { if (item.name == name) {
                    isAvailable = true;
                } });
                if (!isAvailable){
                    dict.push({name: name, price: price, id: id})
                }
            } else {
                dict.push({name: name, price: price,  id: id})
            }
            localStorage.setItem("dict", JSON.stringify(dict));
            if (cart.length > 0){
                let isChanged = false;
                cart.forEach(function(item, i) { if (item[0] == id) {
                    cart[i] = newItem;
                    isChanged = true;
                } });
                if (!isChanged){
                    cart.push(newItem);
                }
            } else {
                cart.push(newItem);
            }
            localStorage.setItem("cart", JSON.stringify(cart));
            alert("Hoan Tat");
        });
        })
    </script>
</head>
<?php

    $mysqli = new mysqli("localhost", "root", "", "TCH");
    session_start();
    // Check connection
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
    }


echo " 
    <body> 
        <nav class=\"bg-black flex items-center justify-between flex-wrap p-6\">\n    <div class=\"flex items-center flex-shrink-0 text-white mr-6\">\n        <a href=\"index.php\" title=\"the coffee house\">\n            <svg class=\"h-10 fill-current text-white\">\n                <use xmlns:xlink=\"http://www.w3.org/1999/xlink\" xlink:href=\"#logo\">\n                    <svg id=\"logo\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 257.685 20\"><path class=\"a\" d=\"M11.8,4.864c0,.266-.228.455-.569.455H7.97V20.234c0,.228-.19.455-.569.455H4.364a.521.521,0,0,1-.569-.455V5.319H.569C.228,5.319,0,5.129,0,4.864V2.093A.547.547,0,0,1,.569,1.6H11.2a.523.523,0,0,1,.569.493v2.77Z\" transform=\"translate(0 -0.993)\"></path><path class=\"a\" d=\"M52.056,1.2a.548.548,0,0,1,.569.455V19.948a.548.548,0,0,1-.569.455H48.982a.549.549,0,0,1-.569-.455V12.623H42.075v7.324a.548.548,0,0,1-.569.455H38.469a.549.549,0,0,1-.569-.455V1.655a.519.519,0,0,1,.569-.455h3.036a.521.521,0,0,1,.569.455V8.676H48.45V1.655A.519.519,0,0,1,49.02,1.2Z\" transform=\"translate(-23.517 -0.745)\"></path><path class=\"a\" d=\"M92.575,5.109V8.9h6.983c.38,0,.569.228.569.455v2.922c0,.228-.19.455-.569.455H92.575v3.757h8.463c.38,0,.607.228.607.455v2.96a.562.562,0,0,1-.607.455H88.969a.549.549,0,0,1-.569-.455V1.655c0-.266.228-.455.569-.455h12.106c.38,0,.607.228.607.455v2.96a.562.562,0,0,1-.607.455h-8.5Z\" transform=\"translate(-54.852 -0.745)\"></path><path class=\"a\" d=\"M169.786,14.494a.689.689,0,0,1,.759,0l2.125,2.125a.577.577,0,0,1,0,.759,9.672,9.672,0,0,1-6.793,2.732,9.429,9.429,0,0,1-9.677-9.829C156.2,4.513,160.185.3,165.877.3a9.865,9.865,0,0,1,6.831,2.77.7.7,0,0,1-.038.721l-2.125,2.125a.689.689,0,0,1-.759,0,5.651,5.651,0,0,0-3.909-1.67c-3.378,0-5.427,2.657-5.427,6.034,0,3.605,2.429,5.806,5.427,5.806a5.417,5.417,0,0,0,3.909-1.594\" transform=\"translate(-96.921 -0.186)\"></path><path class=\"a\" d=\"M211.588,7.324a3.207,3.207,0,1,0,6.414,0,3.207,3.207,0,1,0-6.414,0M221.418,19.2a.562.562,0,0,1-.607.455H208.628a.521.521,0,0,1-.569-.455V16.129a.523.523,0,0,1,.569-.493H220.81a.561.561,0,0,1,.607.493ZM207.3,7.324a7.459,7.459,0,0,1,14.915,0,7.46,7.46,0,0,1-14.915,0\" transform=\"translate(-128.628)\"></path><path class=\"a\" d=\"M260.475,5.585V9.152h6.983c.379,0,.569.228.569.455v3c0,.228-.19.455-.569.455h-6.983v7.1c0,.228-.19.455-.569.455h-3.036a.549.549,0,0,1-.569-.455V2.093a.523.523,0,0,1,.569-.493h12.106a.561.561,0,0,1,.607.493v3a.56.56,0,0,1-.607.493Z\" transform=\"translate(-159.032 -0.993)\"></path><path class=\"a\" d=\"M303.475,5.585V9.152h6.983c.379,0,.569.228.569.455v3c0,.228-.19.455-.569.455h-6.983v7.1c0,.228-.19.455-.569.455h-3.036a.549.549,0,0,1-.569-.455V2.093a.523.523,0,0,1,.569-.493h12.106a.561.561,0,0,1,.607.493v3a.56.56,0,0,1-.607.493Z\" transform=\"translate(-185.714 -0.993)\"></path><path class=\"a\" d=\"M346.413,5.109V8.9H353.4c.38,0,.569.228.569.455v2.922c0,.228-.19.455-.569.455h-6.983v3.757h8.463c.38,0,.607.228.607.455v2.96a.562.562,0,0,1-.607.455H342.769a.549.549,0,0,1-.569-.455V1.655c0-.266.228-.455.569-.455h12.106c.38,0,.607.228.607.455v2.96a.562.562,0,0,1-.607.455h-8.463Z\" transform=\"translate(-212.333 -0.745)\"></path><path class=\"a\" d=\"M390.013,5.109V8.9H397c.379,0,.569.228.569.455v2.922c0,.228-.19.455-.569.455h-6.983v3.757h8.463c.379,0,.607.228.607.455v2.96a.562.562,0,0,1-.607.455H386.369a.549.549,0,0,1-.569-.455V1.655c0-.266.228-.455.569-.455h12.106c.379,0,.607.228.607.455v2.96a.562.562,0,0,1-.607.455h-8.463Z\" transform=\"translate(-239.386 -0.745)\"></path><path class=\"a\" d=\"M469.594,1.2a.548.548,0,0,1,.569.455V19.948a.548.548,0,0,1-.569.455H466.52a.549.549,0,0,1-.569-.455V12.623h-6.376v7.324a.548.548,0,0,1-.569.455h-3.036a.549.549,0,0,1-.569-.455V1.655a.519.519,0,0,1,.569-.455h3.036a.521.521,0,0,1,.569.455V8.676h6.376V1.655a.519.519,0,0,1,.569-.455Z\" transform=\"translate(-282.573 -0.745)\"></path><path class=\"a\" d=\"M508.55,7.324a3.207,3.207,0,1,0,6.414,0,3.207,3.207,0,1,0-6.414,0M518.38,19.2a.562.562,0,0,1-.607.455H505.59a.521.521,0,0,1-.569-.455V16.129a.523.523,0,0,1,.569-.493h12.182a.561.561,0,0,1,.607.493ZM504.3,7.324a7.459,7.459,0,0,1,14.915,0,7.46,7.46,0,0,1-14.915,0\" transform=\"translate(-312.915)\"></path><path class=\"a\" d=\"M553.3,14.389V2.093a.547.547,0,0,1,.569-.493h3.036a.548.548,0,0,1,.569.493V14.351a3.117,3.117,0,0,0,3.188,2.619c1.594,0,3.15-.835,3.15-2.543V2.093a.547.547,0,0,1,.569-.493h3.074a.577.577,0,0,1,.569.493v12.3c0,4.137-3.188,6.565-7.362,6.565-4.061,0-7.362-2.543-7.362-6.565\" transform=\"translate(-343.319 -0.993)\"></path><path class=\"a\" d=\"M602,14.566c0-.266.228-.455.569-.455h3.036c.266,0,.569.152.569.455a1.847,1.847,0,0,0,2.049,1.784,1.88,1.88,0,0,0,2.049-1.822,2.233,2.233,0,0,0-2.049-2.049,7.543,7.543,0,0,1-2.96-.645A5.557,5.557,0,0,1,602,6.6a5.994,5.994,0,0,1,6.262-6c3.416,0,6.11,2.315,6.186,5.655a.519.519,0,0,1-.569.455h-3a.548.548,0,0,1-.569-.455A1.823,1.823,0,0,0,608.3,4.547,1.911,1.911,0,0,0,606.25,6.6,2.007,2.007,0,0,0,608.3,8.608a7.411,7.411,0,0,1,2.922.645,5.621,5.621,0,0,1,3.3,5.275c0,3.8-3.036,5.844-6.224,5.844-3.529-.114-6.262-2.125-6.3-5.806\" transform=\"translate(-373.537 -0.372)\"></path><path class=\"a\" d=\"M648.212,5.109V8.9H655.2c.38,0,.569.228.569.455v2.922c0,.228-.19.455-.569.455h-6.983v3.757h8.463c.38,0,.607.228.607.455v2.96a.562.562,0,0,1-.607.455H644.569A.549.549,0,0,1,644,19.91V1.655c0-.266.228-.455.569-.455h12.106c.38,0,.607.228.607.455v2.96a.562.562,0,0,1-.607.455h-8.463Z\" transform=\"translate(-399.598 -0.745)\"></path></svg>\n                </use>\n            </svg>\n        </a>\n    </div>\n    <div class=\"w-full block flex-grow lg:flex lg:items-center lg:w-auto\">\n        <div class=\"lg:text-sm sm:text-3xl lg:flex-grow\">\n            <a href=\"gioithieu.html\" class=\"font-extrabold text-lg block mt-4 lg:inline-block lg:mt-0 text-white hover:text-orange-500 mr-4\">\n                GIỚI THIỆU\n            </a>\n            <a href=\"lienhe.html\" class=\"font-extrabold text-lg block mt-4 lg:inline-block lg:mt-0 text-white hover:text-orange-500 mr-4\">\n                LIÊN HỆ\n            </a>\n            <a href=\"product_list.html\" class=\"font-extrabold text-lg block mt-4 lg:inline-block lg:mt-0 text-white hover:text-orange-500 mr-4\">\n                SẢN PHẨM\n            </a>\n            <a href=\"login.html\" class=\"font-extrabold text-lg block mt-4 lg:inline-block lg:mt-0 text-white hover:text-orange-500 mr-4\">\n                ĐĂNG NHẬP\n            </a>\n            <a href=\"register.html\" class=\"font-extrabold text-lg block mt-4 lg:inline-block lg:mt-0 text-white hover:text-orange-500 mr-4\">\n                ĐĂNG KÝ\n            </a>\n            <a href=\"logout.php\" class=\"font-extrabold text-lg block mt-4 lg:inline-block lg:mt-0 text-white hover:text-orange-500 mr-4\">\n                ĐĂNG XUẤT\n            </a>\n            <a href=\"cart.html\" class=\"font-extrabold text-lg block mt-4 lg:inline-block lg:mt-0 text-white hover:text-orange-500 mr-4\">\n                GIỎ HÀNG\n            </a>\n            <a href=\"manage/index.php\" class=\"font-extrabold text-lg block mt-4 lg:inline-block lg:mt-0 text-white hover:text-orange-500\">\n                MANAGEMENT\n            </a>\n        </div>\n    </div>\n</nav> 
        <main class=\"bg-white\"> 
            <div class=\"w-full mx-auto mt-5\"> 
                    <div class=\"container bg-gray-100 grid lg:grid-cols-2 sm:grid-cols-1 mx-auto\"> 
                        <img class=\"w-full\" src=\"https://product.hstatic.net/1000075078/product/tra_dao_5f3925d9bfca4d0abc17f95b05fff5f7_master.jpg\" alt=\"Sunset in the mountains\"> 
                        <div class=\"flex flex-wrap content-center justify-center p-5 h-1/2 w-2/3 mx-auto\">";






// Begin Query

    $id = $_GET["id"];
    $query = $mysqli->prepare("select name, price from item where id = ?");
    $query->bind_param("s",$id);
    $query->execute();
    $res = $query->get_result();
    $res = $res->fetch_object();
    $name= $res->name;
    $price = $res->price;
    $query->close();
    echo "<div id=\"name\" class=\"font-bold text-lg sm:text-3xl mb-2 hover:text-orange-500 duration-300 h-32 duration-500\">".$name."&nbsp</div>"; echo "<p id=\"price\" class=\"sm:text-3xl text-lg font-extrabold text-orange-500 mb-2\">".$price. "Đ</p>";
    // End Query
    echo "
    <div class=\"row\">
        <a>Số lượng: &nbsp;</a>
        <input id=\"quantity\" class=\"border border-black\" type=\"number\" min=\"0\" value=\"1\" step=\"1\" id=\"quantity\" name=\"quantity\">
    </div>
    <div class=\"row\">
        <button id=\"purchase\" class=\"border-black border\">Mua Ngay</button>
    </div>";



    echo "</div>
    </div>
    <div class=\"container my-10 mx-auto flex justify-center\">
        <p class=\"sm:text-3xl text-lg font-extrabold text-orange-500 mb-2\">CÓ THỂ BẠN THÍCH</p>
    </div>
    <div class=\"container mx-auto\">
        <div class=\"grid lg:grid-cols-3 sm:grid-cols-1 gap-4 my-10\">";
    $query = $mysqli->prepare("select name, id, price from item order by rand() limit 3");
    $query->execute();
    $res = $query->get_result();
    $res = $res->fetch_all(MYSQLI_ASSOC);
    foreach ($res as $item){
        $item_name = $item["name"];
        $item_id = $item["id"];
        $item_price = $item["price"];
        echo "<div class=\"max-w rounded overflow-hidden shadow-lg mb-5\">
                <img class=\"w-full\" src=\"https://product.hstatic.net/1000075078/product/tra_buoi_5c4c5ce2d4e44042a069ec9011ef1a9f_large.jpg\" alt=\"Sunset in the mountains\">
                <div class=\"px-6 py-4\">
                    <div class=\"font-bold text-lg sm:text-3xl mb-2 hover:text-orange-500 duration-300 h-32 duration-500\"><a href=\"product.php?id=$item_id\">$item_name</a></div>
                    <p class=\"sm:text-3xl text-lg font-extrabold text-orange-500 mb-2\">$item_price Đ</p>
                </div>
                <div class=\"px-6 pt-4 pb-2 mb-2\">
                    <div class=\"grid grid-cols-2 gap-4\">
                        <button class=\"border-orange-500 border-2 sm:text-3xl lg:text-2xl transition duration-500 ease-in-out bg-orange-500 bg-orange-500 text-white hover:text-orange-500 hover:bg-white px-3\">
                            MUA NGAY
                        </button>
                        <button class=\"border-orange-500 border-2 sm:text-3xl lg:text-2xl transition duration-500 ease-in-out  bg-white text-orange-500 hover:text-white hover:bg-orange-500 px-3\">
                            TÌM HIỂU THÊM
                        </button>
                    </div>
                </div>
            </div>";
    }
        echo "</div>
    </div>
</div>
</main>
<footer class=\"bg-black p-6\">
<div class=\"grid px-5 text-white lg:grid-cols-3 sm:grid-cols-1\">
<svg class=\"h-10 fill-current text-white sm:mx-auto\" >
    <use xmlns:xlink=\"http://www.w3.org/1999/xlink\" xlink:href=\"#logo\">
        <svg id=\"logo\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 257.685 20\"><path class=\"a\" d=\"M11.8,4.864c0,.266-.228.455-.569.455H7.97V20.234c0,.228-.19.455-.569.455H4.364a.521.521,0,0,1-.569-.455V5.319H.569C.228,5.319,0,5.129,0,4.864V2.093A.547.547,0,0,1,.569,1.6H11.2a.523.523,0,0,1,.569.493v2.77Z\" transform=\"translate(0 -0.993)\"></path><path class=\"a\" d=\"M52.056,1.2a.548.548,0,0,1,.569.455V19.948a.548.548,0,0,1-.569.455H48.982a.549.549,0,0,1-.569-.455V12.623H42.075v7.324a.548.548,0,0,1-.569.455H38.469a.549.549,0,0,1-.569-.455V1.655a.519.519,0,0,1,.569-.455h3.036a.521.521,0,0,1,.569.455V8.676H48.45V1.655A.519.519,0,0,1,49.02,1.2Z\" transform=\"translate(-23.517 -0.745)\"></path><path class=\"a\" d=\"M92.575,5.109V8.9h6.983c.38,0,.569.228.569.455v2.922c0,.228-.19.455-.569.455H92.575v3.757h8.463c.38,0,.607.228.607.455v2.96a.562.562,0,0,1-.607.455H88.969a.549.549,0,0,1-.569-.455V1.655c0-.266.228-.455.569-.455h12.106c.38,0,.607.228.607.455v2.96a.562.562,0,0,1-.607.455h-8.5Z\" transform=\"translate(-54.852 -0.745)\"></path><path class=\"a\" d=\"M169.786,14.494a.689.689,0,0,1,.759,0l2.125,2.125a.577.577,0,0,1,0,.759,9.672,9.672,0,0,1-6.793,2.732,9.429,9.429,0,0,1-9.677-9.829C156.2,4.513,160.185.3,165.877.3a9.865,9.865,0,0,1,6.831,2.77.7.7,0,0,1-.038.721l-2.125,2.125a.689.689,0,0,1-.759,0,5.651,5.651,0,0,0-3.909-1.67c-3.378,0-5.427,2.657-5.427,6.034,0,3.605,2.429,5.806,5.427,5.806a5.417,5.417,0,0,0,3.909-1.594\" transform=\"translate(-96.921 -0.186)\"></path><path class=\"a\" d=\"M211.588,7.324a3.207,3.207,0,1,0,6.414,0,3.207,3.207,0,1,0-6.414,0M221.418,19.2a.562.562,0,0,1-.607.455H208.628a.521.521,0,0,1-.569-.455V16.129a.523.523,0,0,1,.569-.493H220.81a.561.561,0,0,1,.607.493ZM207.3,7.324a7.459,7.459,0,0,1,14.915,0,7.46,7.46,0,0,1-14.915,0\" transform=\"translate(-128.628)\"></path><path class=\"a\" d=\"M260.475,5.585V9.152h6.983c.379,0,.569.228.569.455v3c0,.228-.19.455-.569.455h-6.983v7.1c0,.228-.19.455-.569.455h-3.036a.549.549,0,0,1-.569-.455V2.093a.523.523,0,0,1,.569-.493h12.106a.561.561,0,0,1,.607.493v3a.56.56,0,0,1-.607.493Z\" transform=\"translate(-159.032 -0.993)\"></path><path class=\"a\" d=\"M303.475,5.585V9.152h6.983c.379,0,.569.228.569.455v3c0,.228-.19.455-.569.455h-6.983v7.1c0,.228-.19.455-.569.455h-3.036a.549.549,0,0,1-.569-.455V2.093a.523.523,0,0,1,.569-.493h12.106a.561.561,0,0,1,.607.493v3a.56.56,0,0,1-.607.493Z\" transform=\"translate(-185.714 -0.993)\"></path><path class=\"a\" d=\"M346.413,5.109V8.9H353.4c.38,0,.569.228.569.455v2.922c0,.228-.19.455-.569.455h-6.983v3.757h8.463c.38,0,.607.228.607.455v2.96a.562.562,0,0,1-.607.455H342.769a.549.549,0,0,1-.569-.455V1.655c0-.266.228-.455.569-.455h12.106c.38,0,.607.228.607.455v2.96a.562.562,0,0,1-.607.455h-8.463Z\" transform=\"translate(-212.333 -0.745)\"></path><path class=\"a\" d=\"M390.013,5.109V8.9H397c.379,0,.569.228.569.455v2.922c0,.228-.19.455-.569.455h-6.983v3.757h8.463c.379,0,.607.228.607.455v2.96a.562.562,0,0,1-.607.455H386.369a.549.549,0,0,1-.569-.455V1.655c0-.266.228-.455.569-.455h12.106c.379,0,.607.228.607.455v2.96a.562.562,0,0,1-.607.455h-8.463Z\" transform=\"translate(-239.386 -0.745)\"></path><path class=\"a\" d=\"M469.594,1.2a.548.548,0,0,1,.569.455V19.948a.548.548,0,0,1-.569.455H466.52a.549.549,0,0,1-.569-.455V12.623h-6.376v7.324a.548.548,0,0,1-.569.455h-3.036a.549.549,0,0,1-.569-.455V1.655a.519.519,0,0,1,.569-.455h3.036a.521.521,0,0,1,.569.455V8.676h6.376V1.655a.519.519,0,0,1,.569-.455Z\" transform=\"translate(-282.573 -0.745)\"></path><path class=\"a\" d=\"M508.55,7.324a3.207,3.207,0,1,0,6.414,0,3.207,3.207,0,1,0-6.414,0M518.38,19.2a.562.562,0,0,1-.607.455H505.59a.521.521,0,0,1-.569-.455V16.129a.523.523,0,0,1,.569-.493h12.182a.561.561,0,0,1,.607.493ZM504.3,7.324a7.459,7.459,0,0,1,14.915,0,7.46,7.46,0,0,1-14.915,0\" transform=\"translate(-312.915)\"></path><path class=\"a\" d=\"M553.3,14.389V2.093a.547.547,0,0,1,.569-.493h3.036a.548.548,0,0,1,.569.493V14.351a3.117,3.117,0,0,0,3.188,2.619c1.594,0,3.15-.835,3.15-2.543V2.093a.547.547,0,0,1,.569-.493h3.074a.577.577,0,0,1,.569.493v12.3c0,4.137-3.188,6.565-7.362,6.565-4.061,0-7.362-2.543-7.362-6.565\" transform=\"translate(-343.319 -0.993)\"></path><path class=\"a\" d=\"M602,14.566c0-.266.228-.455.569-.455h3.036c.266,0,.569.152.569.455a1.847,1.847,0,0,0,2.049,1.784,1.88,1.88,0,0,0,2.049-1.822,2.233,2.233,0,0,0-2.049-2.049,7.543,7.543,0,0,1-2.96-.645A5.557,5.557,0,0,1,602,6.6a5.994,5.994,0,0,1,6.262-6c3.416,0,6.11,2.315,6.186,5.655a.519.519,0,0,1-.569.455h-3a.548.548,0,0,1-.569-.455A1.823,1.823,0,0,0,608.3,4.547,1.911,1.911,0,0,0,606.25,6.6,2.007,2.007,0,0,0,608.3,8.608a7.411,7.411,0,0,1,2.922.645,5.621,5.621,0,0,1,3.3,5.275c0,3.8-3.036,5.844-6.224,5.844-3.529-.114-6.262-2.125-6.3-5.806\" transform=\"translate(-373.537 -0.372)\"></path><path class=\"a\" d=\"M648.212,5.109V8.9H655.2c.38,0,.569.228.569.455v2.922c0,.228-.19.455-.569.455h-6.983v3.757h8.463c.38,0,.607.228.607.455v2.96a.562.562,0,0,1-.607.455H644.569A.549.549,0,0,1,644,19.91V1.655c0-.266.228-.455.569-.455h12.106c.38,0,.607.228.607.455v2.96a.562.562,0,0,1-.607.455h-8.463Z\" transform=\"translate(-399.598 -0.745)\"></path></svg>
    </use>
</svg>
<div class=\"flex-col\">
    <p class=\"font-bold text-xl text-center\">ADDRESS</p>
    <p class=\"text-center\">86 - 88 Cao Thang, Ward 4, District 3,</p>
    <p class=\"text-center\">Ho Chi Minh, Vietnam.</p>
    <p class=\"text-center\">Head Office 2: 62 Tran Quang Khai, Tan Dinh Ward, </p>
    <p class=\"text-center\">District 1 Ho Chi Minh, Vietnam</p>
    <p class=\"text-center\">+842871 078 079</p>
    <p class=\"text-center\">hi@thecoffeehouse.vn</p>
</div>
<div class=\"flex-col\">
    <p class=\"font-bold text-xl text-center\">ALWAYS ON SUPPORT</p>
    <p class=\"text-center\">Delivery 1800 6936 (07:00-21:00)</p>
    <p class=\"text-center\">Support +842871 078 079 (07:00-21:00)</p>
</div>
</div>
</footer>

</body>
</html>";

