<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $categories = [
            [
                'name' => 'Mugs & Drinkware',
                'base_price' => 250,
                'image' => '/images/products/mug.png',
                'folder' => '1. mugs&drinkwares',
                'options' => [
                    ['type' => 'text', 'name' => 'Custom Text', 'values' => null],
                    ['type' => 'image', 'name' => 'Upload Photo', 'values' => null],
                    ['type' => 'color', 'name' => 'Color', 'values' => ['white', 'black', 'red', 'blue']],
                    ['type' => 'material', 'name' => 'Material', 'values' => ['ceramic', 'steel']],
                ],
                'rules' => [
                    ['condition_key' => 'material', 'operator' => '=', 'condition_value' => 'steel', 'price_adjustment' => 150, 'type' => 'fixed'],
                    ['condition_key' => 'text', 'operator' => 'text_length>', 'condition_value' => '10', 'price_adjustment' => 50, 'type' => 'fixed'],
                ]
            ],
            [
                'name' => 'T-Shirts & Apparel',
                'base_price' => 500,
                'image' => '/images/products/custom_tshirt.png',
                'folder' => '2.tshirts&apparel',
                'options' => [
                    ['type' => 'print_text', 'name' => 'Print Text', 'values' => null],
                    ['type' => 'photo', 'name' => 'Upload Design', 'values' => null],
                    ['type' => 'size', 'name' => 'Size', 'values' => ['S', 'M', 'L', 'XL', 'XXL']],
                    ['type' => 'fabric', 'name' => 'Fabric Quality', 'values' => ['standard_cotton', 'premium_blend']],
                ],
                'rules' => [
                    ['condition_key' => 'fabric', 'operator' => '=', 'condition_value' => 'premium_blend', 'price_adjustment' => 250, 'type' => 'fixed'],
                ]
            ],
            [
                'name' => 'Phone Cases',
                'base_price' => 300,
                'image' => '/images/products/phone_case.png',
                'folder' => '3.phonecases',
                'options' => [
                    ['type' => 'model', 'name' => 'Phone Model', 'values' => ['iPhone 14', 'iPhone 15', 'Samsung S23', 'Samsung S24', 'Pixel 8']],
                    ['type' => 'photo', 'name' => 'Back Photo', 'values' => null],
                    ['type' => 'finish', 'name' => 'Finish', 'values' => ['matte', 'glossy', 'glass_back']],
                ],
                'rules' => [
                    ['condition_key' => 'finish', 'operator' => '=', 'condition_value' => 'glass_back', 'price_adjustment' => 200, 'type' => 'fixed'],
                ]
            ],
            [
                'name' => 'Photo Frames & Wall Art',
                'base_price' => 600,
                'image' => '/images/products/photo_frame.png',
                'folder' => '4.photoframes&wallarts',
                'options' => [
                    ['type' => 'frame_type', 'name' => 'Frame Type', 'values' => ['synthetic_wood', 'premium_oak', 'metal']],
                    ['type' => 'size', 'name' => 'Size', 'values' => ['8x10', '12x16', '16x20']],
                ],
                'rules' => [
                    ['condition_key' => 'frame_type', 'operator' => '=', 'condition_value' => 'premium_oak', 'price_adjustment' => 300, 'type' => 'fixed'],
                    ['condition_key' => 'size', 'operator' => '=', 'condition_value' => '16x20', 'price_adjustment' => 400, 'type' => 'fixed'],
                ]
            ],
            [
                'name' => 'Keychains',
                'base_price' => 150,
                'image' => '/images/products/keychain.png',
                'folder' => '5.keychains',
                'options' => [
                    ['type' => 'engraving', 'name' => 'Name Engraving', 'values' => null],
                    ['type' => 'shape', 'name' => 'Shape', 'values' => ['circle', 'square', 'heart']],
                    ['type' => 'material', 'name' => 'Material', 'values' => ['acrylic', 'wood', 'metal']],
                ],
                'rules' => [
                    ['condition_key' => 'material', 'operator' => '=', 'condition_value' => 'metal', 'price_adjustment' => 100, 'type' => 'fixed'],
                ]
            ],
            [
                'name' => 'Notebooks & Diaries',
                'base_price' => 400,
                'image' => '/images/products/notebook.png',
                'folder' => '6.notebooks&diaries',
                'options' => [
                    ['type' => 'cover_name', 'name' => 'Name on Cover', 'values' => null],
                    ['type' => 'cover_material', 'name' => 'Cover Material', 'values' => ['hardcover', 'leather']],
                    ['type' => 'pages_type', 'name' => 'Pages Type', 'values' => ['ruled', 'unruled', 'dotted']],
                ],
                'rules' => [
                    ['condition_key' => 'cover_material', 'operator' => '=', 'condition_value' => 'leather', 'price_adjustment' => 200, 'type' => 'fixed'],
                ]
            ],
            [
                'name' => 'Candles & Decorative',
                'base_price' => 350,
                'image' => '/images/products/candle.png',
                'folder' => '7.candles&decorativeItems',
                'options' => [
                    ['type' => 'message', 'name' => 'Custom Message', 'values' => null],
                    ['type' => 'scent', 'name' => 'Scent', 'values' => ['vanilla', 'lavender', 'sandalwood', 'rose']],
                    ['type' => 'jar_type', 'name' => 'Jar Type', 'values' => ['glass', 'ceramic_pot']],
                ],
                'rules' => [
                    ['condition_key' => 'jar_type', 'operator' => '=', 'condition_value' => 'ceramic_pot', 'price_adjustment' => 150, 'type' => 'fixed'],
                ]
            ],
            [
                'name' => 'Bags (Tote / Backpack)',
                'base_price' => 450,
                'image' => '/images/products/bag.png',
                'folder' => '8. bags(tote&backpacks)',
                'options' => [
                    ['type' => 'print_design', 'name' => 'Print Text/Design Code', 'values' => null],
                    ['type' => 'size', 'name' => 'Size', 'values' => ['standard', 'large']],
                    ['type' => 'material', 'name' => 'Material', 'values' => ['canvas', 'jute']],
                ],
                'rules' => [
                    ['condition_key' => 'size', 'operator' => '=', 'condition_value' => 'large', 'price_adjustment' => 150, 'type' => 'fixed'],
                ]
            ],
            [
                'name' => 'Soft Toys',
                'base_price' => 600,
                'image' => '/images/products/soft_toy.png',
                'folder' => '9.soft Toys',
                'options' => [
                    ['type' => 'tshirt_message', 'name' => 'Message on T-Shirt', 'values' => null],
                    ['type' => 'color', 'name' => 'Color', 'values' => ['brown', 'white', 'pink']],
                    ['type' => 'size', 'name' => 'Size', 'values' => ['small', 'medium', 'giant']],
                ],
                'rules' => [
                    ['condition_key' => 'size', 'operator' => '=', 'condition_value' => 'giant', 'price_adjustment' => 800, 'type' => 'fixed'],
                ]
            ],
            [
                'name' => 'Watches & Accessories',
                'base_price' => 1200,
                'image' => '/images/products/watch.png',
                'folder' => '10.watches',
                'options' => [
                    ['type' => 'engraving', 'name' => 'Back Engraving', 'values' => null],
                    ['type' => 'strap_type', 'name' => 'Strap Type', 'values' => ['silicone', 'leather', 'metal_chain']],
                    ['type' => 'dial_design', 'name' => 'Dial Design', 'values' => ['minimalist', 'chronograph_style']],
                ],
                'rules' => [
                    ['condition_key' => 'strap_type', 'operator' => '=', 'condition_value' => 'metal_chain', 'price_adjustment' => 500, 'type' => 'fixed'],
                ]
            ],
            [
                'name' => 'Chocolates & Hampers',
                'base_price' => 800,
                'image' => '/images/products/hamper.png',
                'folder' => '11.chocolates&giftHampers',
                'options' => [
                    ['type' => 'message', 'name' => 'Message on Card', 'values' => null],
                    ['type' => 'date', 'name' => 'Delivery Date', 'values' => null],
                    ['type' => 'packaging', 'name' => 'Packaging Style', 'values' => ['standard_box', 'premium_wooden_box']],
                ],
                'rules' => [
                    ['condition_key' => 'packaging', 'operator' => '=', 'condition_value' => 'premium_wooden_box', 'price_adjustment' => 400, 'type' => 'fixed'],
                ]
            ],
            [
                'name' => 'Wooden Engraved Gifts',
                'base_price' => 700,
                'image' => '/images/products/wooden_gift.png',
                'options' => [
                    ['type' => 'laser_engraving', 'name' => 'Laser Engraving Text', 'values' => null],
                    ['type' => 'size', 'name' => 'Size', 'values' => ['small', 'medium', 'large']],
                ],
                'rules' => [
                    ['condition_key' => 'size', 'operator' => '=', 'condition_value' => 'large', 'price_adjustment' => 300, 'type' => 'fixed'],
                ]
            ],
        ];

        $adjectives = ['Premium', 'Classic', 'Modern', 'Luxury', 'Minimalist', 'Vintage', 'Elegant', 'Custom', 'Personalized', 'Exclusive'];

        foreach ($categories as $cat) {
            $folder = $cat['folder'] ?? null;
            $images = [];
            if ($folder && File::exists(public_path('images/products/' . $folder))) {
                $images = File::files(public_path('images/products/' . $folder));
            }

            for ($i = 1; $i <= 10; $i++) {
                $adj = $adjectives[array_rand($adjectives)];
                $productName = $adj . ' ' . rtrim($cat['name'], 's');
                
                // Adjust base price slightly for variety
                $variationPrice = $cat['base_price'] + (rand(-2, 5) * 50);
                if ($variationPrice <= 0) $variationPrice = 100;

                $imageUrl = $cat['image'] ?? '/images/products/default.png';
                if (!empty($images)) {
                    $imageIndex = ($i - 1) % count($images);
                    $imageUrl = '/images/products/' . $folder . '/' . $images[$imageIndex]->getFilename();
                }

                $product = Product::create([
                    'name' => $productName . ' V' . $i,
                    'category' => $cat['name'],
                    'description' => "This is a beautifully crafted $productName, perfect for gifting. Customise it to make it uniquely yours.",
                    'base_price' => $variationPrice,
                    'image_url' => $imageUrl,
                    'rating' => rand(40, 50) / 10,
                    'reviews_count' => rand(12, 450),
                    'specifications' => [
                        'Brand' => 'GiftStore Premium',
                        'Material' => $cat['options'][array_search('Material', array_column($cat['options'], 'name'))]['values'][0] ?? 'High Quality',
                        'Dimensions' => rand(10, 30) . 'D x ' . rand(10, 30) . 'W x ' . rand(10, 30) . 'H Centimeters',
                        'Weight' => rand(100, 1000) . ' Grams',
                        'Warranty' => '6 Months Manufacturer Warranty'
                    ]
                ]);

                foreach ($cat['options'] as $option) {
                    $product->customizationOptions()->create([
                        'type' => $option['type'],
                        'name' => $option['name'],
                        'values' => $option['values']
                    ]);
                }

                foreach ($cat['rules'] as $rule) {
                    $product->pricingRules()->create([
                        'condition_key' => $rule['condition_key'],
                        'operator' => $rule['operator'],
                        'condition_value' => $rule['condition_value'],
                        'price_adjustment' => $rule['price_adjustment'],
                        'type' => $rule['type']
                    ]);
                }
            }
        }
    }
}
