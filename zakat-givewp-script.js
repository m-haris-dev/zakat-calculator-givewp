document.addEventListener("DOMContentLoaded", function () {
  const inputs = document.querySelectorAll(".zakat-givewp-calculator input, .zakat-givewp-calculator select");
  const zakatRate = 0.025;
  const tolaToGram = 11.664;
  const goldPricePerGram = 65;
  const silverPricePerGram = 0.80;

  const nisabValues = {
    gold: 7.5 * tolaToGram * goldPricePerGram,
    silver: 52.5 * tolaToGram * silverPricePerGram
  };

  function calculateZakat() {
    const nisabType = document.getElementById('nisabType').value;
    const nisabValue = nisabValues[nisabType];

    document.getElementById('nisabValue').textContent = nisabValue.toFixed(2);
    document.getElementById('nisabValueTotal').textContent = nisabValue.toFixed(2);

    const get = id => parseFloat(document.getElementById(id).value) || 0;

    const totalAssets = get('inventory') + get('investment') + get('tax_refund') + get('shares') + get('cash') + get('gold_silver') + get('bank') + get('loans') + get('deposits');
    const totalLiabilities = get('credit_inventory') + get('taxes_utilities') + get('wages') + get('installments');

    const netAssets = totalAssets - totalLiabilities;
    const zakat = netAssets >= nisabValue ? netAssets * zakatRate : 0;

    document.getElementById('assetsTotal').textContent = netAssets.toFixed(2);
    document.getElementById('zakatTotal').textContent = zakat.toFixed(2);

    // Show/hide Donate section
    const donateWrapper = document.getElementById('zakatDonateWrapper');
    const giveForm = document.getElementById('give-form');
    if (zakat > 0) {
      donateWrapper.style.display = 'block';
    } else {
      donateWrapper.style.display = 'none';
      giveForm.style.display = 'none';
    }
  }

  inputs.forEach(input => {
    input.addEventListener('input', calculateZakat);
    input.addEventListener('change', calculateZakat);
  });

  calculateZakat();

  // Donate button click handler
  const donateBtn = document.getElementById("donateZakatBtn");
  if (donateBtn) {
    donateBtn.addEventListener("click", function () {
      const zakatAmount = document.getElementById("zakatTotal").textContent;
      const roundedAmount = Math.round(zakatAmount);
      const giveAmountField = document.querySelector('input[name="give-amount"]');
      const giveForm = document.getElementById("give-form");
      giveForm.style.display = 'block';
      document.querySelector('.give-final-total-amount').textContent = `$ ${parseFloat(roundedAmount).toFixed(2)}`;
      document.querySelector('.give-final-total-amount').setAttribute('data-total', parseFloat(roundedAmount).toFixed(2));
      document.querySelector('.give-btn-level-0').classList.remove('give-default-level');
      document.querySelector('.give-btn-level-custom').classList.add('give-default-level');
      document.querySelector('input[name="give-price-id"]').value = "custom";

      if (giveAmountField) {
        giveAmountField.value = parseFloat(roundedAmount).toFixed(2);
      }
      if (giveForm) {
        giveForm.scrollIntoView({ behavior: "smooth" });
      }

      let dataSummary = "";

      const nisabType = document.getElementById('nisabType')?.value || '';
      const nisabValue = document.getElementById('nisabValue')?.innerText || '0.00';
      dataSummary += `Nisab Type: ${nisabType}\nNisab Threshold: $${nisabValue}\n\n`;

      document.querySelectorAll('input[type="number"]').forEach(input => {
          const label = input.closest('.field')?.querySelector('label')?.innerText || input.previousElementSibling?.innerText || 'Value';
          const value = input.value.trim() || '0';
          dataSummary += `${label}: ${value}\n`;
      });
      // Insert into textarea
      const textarea = document.querySelector('textarea[name="user_more_data"]');
      if (textarea) {
          textarea.value = dataSummary;
      }

    });
  }
  
});
