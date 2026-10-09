(() => {
    const amountPattern = '(?:[0-9]{1,3}(?:\\.[0-9]{3})+|[0-9]+)(?:,[0-9]{1,2})?';
    const amountRegex = new RegExp(`^(?:${amountPattern})$`);

    const groupDigits = (digits) => digits.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

    const toRawValue = (value) => {
        const [whole, fraction] = value.split(',');
        const integer = whole.replaceAll('.', '');

        return fraction === undefined ? integer : `${integer}.${fraction}`;
    };

    const updateValidity = (input) => {
        input.setCustomValidity('');

        if (input.value === '') {
            if (input.required) {
                input.setCustomValidity('Nominal wajib diisi.');
            }

            return;
        }

        if (!amountRegex.test(input.value)) {
            input.setCustomValidity('Masukkan nominal dengan angka dan pemisah yang benar.');

            return;
        }

        const raw = toRawValue(input.value);
        const integerDigits = raw.split('.')[0].length;

        if (integerDigits > 13) {
            input.setCustomValidity('Nominal maksimal 13 angka sebelum koma.');
        } else if (Number(raw) < Number(input.dataset.moneyMin || 0)) {
            input.setCustomValidity('Nominal harus lebih dari nol.');
        }
    };

    const formatInput = (input, caret = input.selectionStart ?? input.value.length) => {
        const original = input.value;
        const prefix = original.slice(0, caret);
        const digitsBeforeCaret = (prefix.match(/[0-9]/g) || []).length;
        const decimalBeforeCaret = prefix.includes(',');
        const cleaned = original.replace(/[^0-9,]/g, '');

        if (cleaned === '') {
            input.value = '';
            input.setSelectionRange(0, 0);
            updateValidity(input);

            return;
        }

        const decimalIndex = cleaned.indexOf(',');
        const hasDecimal = decimalIndex !== -1;
        let integer = hasDecimal ? cleaned.slice(0, decimalIndex) : cleaned;
        let fraction = hasDecimal ? cleaned.slice(decimalIndex + 1).replaceAll(',', '').slice(0, 2) : '';

        integer = integer.replace(/\D/g, '').replace(/^0+(?=\d)/, '');
        if (integer === '') {
            integer = '0';
        }

        const formatted = `${groupDigits(integer)}${hasDecimal ? `,${fraction}` : ''}`;
        let nextCaret = 0;
        let seenDigits = 0;

        while (nextCaret < formatted.length && seenDigits < digitsBeforeCaret) {
            if (/[0-9]/.test(formatted[nextCaret])) {
                seenDigits += 1;
            }
            nextCaret += 1;
        }

        const commaIndex = formatted.indexOf(',');
        if (decimalBeforeCaret && commaIndex !== -1 && nextCaret <= commaIndex) {
            nextCaret = commaIndex + 1;
        }

        input.value = formatted;
        input.setSelectionRange(nextCaret, nextCaret);
        updateValidity(input);
    };

    document.querySelectorAll('[data-money-input]').forEach((input) => {
        input.type = 'text';
        input.inputMode = 'decimal';
        input.autocomplete = 'off';
        input.pattern = amountPattern;

        if (input.value !== '') {
            formatInput(input, input.value.length);
        } else {
            updateValidity(input);
        }

        input.addEventListener('keydown', (event) => {
            if (input.selectionStart !== input.selectionEnd) {
                return;
            }

            const position = input.selectionStart;

            if (event.key === 'Backspace' && input.value[position - 1] === '.') {
                input.setSelectionRange(Math.max(0, position - 2), position);
            } else if (event.key === 'Delete' && input.value[position] === '.') {
                input.setSelectionRange(position, Math.min(input.value.length, position + 2));
            }
        });

        input.addEventListener('input', () => formatInput(input));
        input.addEventListener('invalid', () => updateValidity(input));

        input.form?.addEventListener('submit', () => {
            input.value = toRawValue(input.value);
        });
    });
})();