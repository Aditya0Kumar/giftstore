<?php

namespace App\Services;

use App\Models\Product;

class PricingService
{
    /**
     * Calculate the dynamic price of a product based on customization inputs and pricing rules.
     *
     * @param Product $product
     * @param array $customizationInputs Key-value pairs of customization options (e.g., ['material' => 'wood', 'text' => 'Happy Bday'])
     * @return float
     */
    public function calculatePrice(Product $product, array $customizationInputs): float
    {
        $basePrice = (float) $product->base_price;
        $additionalCost = 0.0;

        // Fetch pricing rules for this product
        $rules = $product->pricingRules;

        foreach ($rules as $rule) {
            $key = $rule->condition_key;
            $operator = $rule->operator;
            $conditionValue = $rule->condition_value;
            $adjustment = (float) $rule->price_adjustment;
            $type = $rule->type; // 'fixed' or 'percentage'

            // Special case for text length
            $inputValue = $customizationInputs[$key] ?? null;

            if ($inputValue !== null) {
                $match = false;

                // Evaluate condition
                switch ($operator) {
                    case '=':
                        $match = ($inputValue == $conditionValue);
                        break;
                    case '>':
                        $match = (is_numeric($inputValue) && $inputValue > $conditionValue);
                        break;
                    case '<':
                        $match = (is_numeric($inputValue) && $inputValue < $conditionValue);
                        break;
                    case 'text_length>':
                        $match = (is_string($inputValue) && strlen($inputValue) > $conditionValue);
                        break;
                }

                if ($match) {
                    if ($type === 'percentage') {
                        $additionalCost += ($basePrice * ($adjustment / 100));
                    } else {
                        $additionalCost += $adjustment;
                    }
                }
            }
        }

        return $basePrice + $additionalCost;
    }
}
