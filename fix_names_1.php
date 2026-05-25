<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$mappings = [
  "Screenshot 2026-05-14 121246.png" => "Hammered Copper Mugs Set",
  "Screenshot 2026-05-14 121325.png" => "Copper Mug with Brass Handle",
  "Screenshot 2026-05-14 121529.png" => "Ribbed Copper Mug",
  "Screenshot 2026-05-14 121622.png" => "Patterned Glass Cups",
  "Screenshot 2026-05-14 121845.png" => "Clear Ribbed Glass Mug",
  "Screenshot 2026-05-14 121936.png" => "Black Ceramic Mugs Set",
  "Screenshot 2026-05-14 122018.png" => "Two White Ceramic Mugs",
  "Screenshot 2026-05-14 122034.png" => "Stacked White Ceramic Mugs",
  "Screenshot 2026-05-14 122107.png" => "Floral Printed Coffee Mug",
  "Screenshot 2026-05-14 122741.png" => "Glass Beer Mugs",
  "Screenshot 2026-05-14 122842.png" => "Wooden Tankard Mug",
  "Screenshot 2026-05-14 124244.png" => "Palm Leaves Mugs Set",

  "Screenshot 2026-05-14 124838.png" => "Green Patterned Jersey",
  "Screenshot 2026-05-14 124920.png" => "Grey Button Shirt",
  "Screenshot 2026-05-14 125045.png" => "Black Polo Shirt",
  "Screenshot 2026-05-14 125140.png" => "White Graphic T-Shirt",
  "Screenshot 2026-05-15 092020.png" => "Zipper Polo Shirts",
  "Screenshot 2026-05-15 092230.png" => "Butterfly Cream Shirts",
  "Screenshot 2026-05-15 092533.png" => "Rust Red Shirt",
  "Screenshot 2026-05-15 092607.png" => "Teal Strap Dress",
  "Screenshot 2026-05-15 092624.png" => "Blue Linen Shirt",
  "Screenshot 2026-05-15 092824.png" => "Red Cardigan Jacket",
  "Screenshot 2026-05-15 092858.png" => "Blue Knit Sweater",

  "Screenshot 2026-05-15 093313.png" => "Multiple Phone Cases",
  "Screenshot 2026-05-15 093323.png" => "Black Leather Phonecase",
  "Screenshot 2026-05-15 093338.png" => "Owl Phone Case",
  "Screenshot 2026-05-15 093408.png" => "Purple Transparent Phonecase",
  "Screenshot 2026-05-15 093441.png" => "Purple Phonecases Ring-Stands",
  "Screenshot 2026-05-15 093514.png" => "Hustle Culture Phonecase",
  "Screenshot 2026-05-15 093539.png" => "Brown Leather Phonecase",
  "Screenshot 2026-05-15 093630.png" => "White Orange Phonecase",
  "Screenshot 2026-05-15 093805.png" => "Clear Blue MagSafe Case",
  "Screenshot 2026-05-15 093841.png" => "Blue Leather Flipcase",
  "Screenshot 2026-05-15 093912.png" => "Clear Transparent Phonecase",

  "Screenshot 2026-05-15 094449.png" => "Clear Gold Photoframe",
  "Screenshot 2026-05-15 094829.png" => "Brown Gold Photoframe",
  "Screenshot 2026-05-15 094904.png" => "Floral Photo Frame",
  "Screenshot 2026-05-15 095037.png" => "Heart Photo Frame",
  "Screenshot 2026-05-15 095105.png" => "Vintage Photo Frames",
  "Screenshot 2026-05-15 095351.png" => "3D Mountain Wall-Art",
  "Screenshot 2026-05-17 124044.png" => "Backlit Tree Wall-Art",
  "Screenshot 2026-05-17 124608.png" => "Blue Wave Wall-Art",
  "Screenshot 2026-05-17 124730.png" => "Framed Abstract Painting",
  "Screenshot 2026-05-17 124818.png" => "Blue Wall Mural",

  "Screenshot 2026-05-17 125124.png" => "Heart Metal Keychain",
  "Screenshot 2026-05-17 125253.png" => "Evil Eye Owl Keychain",
  "Screenshot 2026-05-17 125315.png" => "Round Evil Eye Keychain",
  "Screenshot 2026-05-17 125338.png" => "Evil Eye Flower Keychain",
  "Screenshot 2026-05-17 125417.png" => "Evil Eye Elephant Keychain",
  "Screenshot 2026-05-17 125505.png" => "Evil Eye Tree Keychain",
  "Screenshot 2026-05-17 125528.png" => "Hamsa Evil Eye Keychain",
  "Screenshot 2026-05-17 125653.png" => "Gold Camel Keychain",
  "Screenshot 2026-05-17 125749.png" => "Ganesha Metal Keychain",
  "Screenshot 2026-05-17 125841.png" => "Ballerina Crystal Keychain",
  "Screenshot 2026-05-17 125941.png" => "Strawberry Daisy Keychain",

  "Screenshot 2026-05-17 130139.png" => "Notebook Coffee Cup",
  "Screenshot 2026-05-17 130225.png" => "Spiral Notebook Keyboard",
  "Screenshot 2026-05-17 130237.png" => "Hand Writing Notebook",
  "Screenshot 2026-05-17 130304.png" => "Brown Leather Notebook",
  "Screenshot 2026-05-17 130333.png" => "Journaling Illustrations Notebook",
  "Screenshot 2026-05-17 130344.png" => "Notebook on Tree Stump",
  "Screenshot 2026-05-17 130405.png" => "Scrapbook Bird Diary",
  "Screenshot 2026-05-17 130422.png" => "Autumn Journal Pink Fur",
  "Screenshot 2026-05-17 130513.png" => "My Life Journal",
  "Screenshot 2026-05-17 130527.png" => "Economics Book Guide",
  "Screenshot 2026-05-17 130610.png" => "Floral Spiral Notebook",
  "Screenshot 2026-05-17 130641.png" => "Pink Gratitude Journal"
];

$products = \App\Models\Product::all();
$updated = 0;

foreach ($products as $product) {
    $filename = basename($product->image_url);
    if (isset($mappings[$filename])) {
        $newName = ucwords($mappings[$filename]);
        
        $product->name = $newName;
        $product->description = "This beautifully crafted $newName is designed to elevate your everyday experience. Meticulously made and perfect for gifting, it embodies the perfect balance of luxury and timeless appeal.";
        $product->save();
        $updated++;
    }
}

echo "Successfully updated $updated products based on actual image contents.\n";
