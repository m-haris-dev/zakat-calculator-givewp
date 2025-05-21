<?php
/**
 * Plugin Name: Zakat GiveWP Calculator
 * Description: A shortcode-based Zakat GiveWP calculator with dynamic Nisab thresholds.
 * Version: 1.0
 * Author: Muhammad Haris
 */

if (!defined('ABSPATH')) exit;

// Enqueue CSS & JS
function zakat_calculator_enqueue_assets() {
    wp_enqueue_style('zakat-givewp-style', plugin_dir_url(__FILE__) . 'zakat-givewp-style.css');
    wp_enqueue_script('zakat-givewp-script', plugin_dir_url(__FILE__) . 'zakat-givewp-script.js', ['jquery'], null, true);
}
add_action('wp_enqueue_scripts', 'zakat_calculator_enqueue_assets');

// Shortcode: [zakat_givewp_calculator]
function zakat_givewp_calculator_shortcode() {
    ob_start(); ?>
    
    <div class="zakat-givewp-calculator">
        
        <div class="zakat-givewp-head">
            <h2>Zakat Calculator</h2>
        </div>
        
        <div class="zakat-givewp-body">

            <label for="nisabType">BASE NISAB ON VALUE OF*</label>
            <select id="nisabType">
                <option value="gold">Gold</option>
                <option value="silver">Silver</option>
            </select>
            <div class="note">
                Guidance: Gold Nisab = 7.5 Tola, Silver Nisab = 52.5 Tola (1 Tola = 11.664 grams)
            </div>

            <div id="nisabValueDisplay">
                Nisab Threshold: $<span id="nisabValue">0.00</span>
            </div>

            <h4>GOLD & SILVER</h4>
            <label>Value of Silver and Gold you possess</label>
            <input type="number" id="gold_silver" min="0">

            <h4>ASSETS</h4>

            <div class="inline-field">
                <div class="field">
                    <label>Cash in hand including foreign currency</label>
                    <input type="number" id="cash" min="0">
                </div>
                <div class="field">
                    <label>Bank Balance (excluding interest)</label>
                    <input type="number" id="bank" min="0">
                </div>
            </div>
            
            <div class="inline-field">
                <div class="field">
                    <label>Value of Shares, Bonds, Funds, Pension Plans, etc.</label>
                    <input type="number" id="shares" min="0">
                </div>
                <div class="field">
                    <label>Money given to others as loan</label>
                    <input type="number" id="loans" min="0">
                </div>
            </div>

            <div class="inline-field">
                <div class="field">
                    <label>Refundable deposits (e.g. Rent)</label>
                    <input type="number" id="deposits" min="0">
                </div>
                <div class="field">
                    <label>Expected Tax Refund</label>
                    <input type="number" id="tax_refund" min="0">
                </div>
            </div>
            
            <h4>BUSINESS ASSETS</h4>

            <div class="inline-field">
                <div class="field">
                    <label>Investment Properties</label>
                    <input type="number" id="investment" min="0">
                </div>
                <div class="field">
                    <label>Business Inventory & Trade Goods</label>
                    <input type="number" id="inventory" min="0">
                </div>
            </div>

            <h4>DEBTS & LIABILITIES</h4>

            <div class="inline-field">
                <div class="field">
                    <label>Inventory & Goods brought on credit</label>
                    <input type="number" id="credit_inventory" min="0">
                </div>
                <div class="field">
                    <label>Taxes and Utilities due immediately</label>
                    <input type="number" id="taxes_utilities" min="0">
                </div>
            </div>

            <div class="inline-field">
                <div class="field">
                    <label>Salaries & Wages due currently</label>
                    <input type="number" id="wages" min="0">
                </div>
                <div class="field">
                    <label>Due Installments of House, Shop and/or Office</label>
                    <input type="number" id="installments" min="0">
                </div>
            </div>

            <div class="total">
                Your current assets are worth: <span> $</span><span id="assetsTotal">0.00</span><br>
                Nisab Applied: <span> $</span><span id="nisabValueTotal">0.00</span><br>
                Zakat Total (2.5%): <span> $</span><span id="zakatTotal">0.00</span>
            </div>

            <div id="zakatDonateWrapper" style="display: none;" class="zakat-donate-button-wrap">
                <button id="donateZakatBtn">Donate This Zakat Amount</button>
            </div>

        </div>

    </div>

    <?php
    return ob_get_clean();
}
add_shortcode('zakat_givewp_calculator', 'zakat_givewp_calculator_shortcode');


