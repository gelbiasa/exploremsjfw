<script>
    $(document).ready(function() {
        // Inisialisasi untuk transaksi order
        console.log('Transaksi Order Management loaded');
        
        // Event handler untuk kalkulasi otomatis jika diperlukan
        $('input[name*="ordr_it_quantity"], input[name*="ordr_it_price"]').on('input', function() {
            // Get the index from the input name
            const name = $(this).attr('name');
            const match = name.match(/\[(\d+)\]/);
            if (match) {
                const index = match[1];
                calculateSubtotalDynamic(index);
            }
        });

        // Auto calculate when quantity changes
        $(document).on('input', 'input[name*="[ordr_it_quantity]"]', function() {
            const name = $(this).attr('name');
            const match = name.match(/\[(\d+)\]/);
            if (match) {
                const index = match[1];
                calculateSubtotalDynamic(index);
            }
        });

        // Real-time validation untuk stock
        $(document).on('input', 'input[name*="[ordr_it_quantity]"]', function() {
            const name = $(this).attr('name');
            const match = name.match(/\[(\d+)\]/);
            if (match) {
                const index = match[1];
                const quantity = parseInt($(this).val()) || 0;
                const maxStock = parseInt($(`#max_stock_${index}`).val()) || 0;
                
                if (quantity > maxStock && maxStock > 0) {
                    $(this).addClass('is-invalid');
                    $(this).after('<div class="invalid-feedback">Stock tidak mencukupi! Tersedia: ' + maxStock + '</div>');
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').remove();
                }
            }
        });
    });
    
    // Function untuk kalkulasi subtotal dinamis
    function calculateSubtotalDynamic(index) {
        const quantity = parseFloat($(`input[name="products[${index}][ordr_it_quantity]"]`).val()) || 0;
        const price = parseFloat($(`input[name="products[${index}][ordr_it_price]"]`).val()) || 0;
        const maxStock = parseInt($(`#max_stock_${index}`).val()) || 0;
        
        // Validasi stock
        if (quantity > maxStock && maxStock > 0) {
            Swal.fire({
                title: 'Stock Tidak Cukup!',
                text: `Stock produk ini tinggal ${maxStock}, tidak memenuhi quantity ${quantity}`,
                icon: 'warning',
                confirmButtonColor: '#028284'
            });
            $(`input[name="products[${index}][ordr_it_quantity]"]`).val(maxStock);
            const subtotal = maxStock * price;
            $(`input[name="products[${index}][ordr_it_subtotal]"]`).val(subtotal);
        } else {
            const subtotal = quantity * price;
            $(`input[name="products[${index}][ordr_it_subtotal]"]`).val(subtotal);
        }
        
        calculateTotalDynamic();
    }
    
    // Function untuk kalkulasi total dinamis
    function calculateTotalDynamic() {
        let total = 0;
        $('input[name*="[ordr_it_subtotal]"]').each(function() {
            const subtotal = parseFloat($(this).val()) || 0;
            total += subtotal;
        });
        $('input[name="ordr_total_amount"]').val(total);
        
        // Format tampilan currency
        $('input[name="ordr_total_amount"]').attr('data-original', total);
    }
    
    // Function untuk format currency
    function formatCurrency(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(amount);
    }
    
    // Function untuk validasi produk yang sama
    function validateDuplicateProductAdvanced(productId, currentIndex) {
        let isDuplicate = false;
        let duplicateIndex = null;
        
        $('input[name*="[fk_pdrk_id]"]').each(function() {
            const name = $(this).attr('name');
            const match = name.match(/\[(\d+)\]/);
            if (match) {
                const index = match[1];
                if (index != currentIndex && $(this).val() == productId) {
                    isDuplicate = true;
                    duplicateIndex = index;
                    return false; // break loop
                }
            }
        });
        
        if (isDuplicate) {
            Swal.fire({
                title: 'Produk Duplikat!',
                text: `Produk ini sudah dipilih pada Produk ${duplicateIndex}. Silakan pilih produk lain atau tingkatkan quantity produk yang sudah ada.`,
                icon: 'warning',
                confirmButtonColor: '#028284',
                showCancelButton: true,
                confirmButtonText: 'Edit Quantity',
                cancelButtonText: 'Pilih Produk Lain'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Focus ke quantity produk yang duplikat
                    $(`#ordr_it_quantity_${duplicateIndex}`).focus().select();
                }
            });
            return false;
        }
        return true;
    }
    
    // Function untuk reset form produk
    function resetProductForm(index) {
        $(`#fk_pdrk_id_${index}`).val('');
        $(`#ordr_it_price_${index}`).val('');
        $(`#max_stock_${index}`).val('');
        $(`#produk_display_${index}`).val('');
        $(`#ordr_it_quantity_${index}`).val('');
        $(`#ordr_it_subtotal_${index}`).val('');
        calculateTotalDynamic();
    }
    
    // Function untuk validasi form sebelum submit
    function validateFormBeforeSubmit() {
        let errors = [];
        
        // Validasi customer
        if (!$('#fk_cust_id').val()) {
            errors.push('Customer belum dipilih');
        }
        
        // Validasi tanggal
        if (!$('input[name="ordr_order_date"]').val()) {
            errors.push('Tanggal order belum diisi');
        }
        
        // Validasi jumlah produk
        const jumlahProduk = $('#jumlah_produk').val();
        if (!jumlahProduk || jumlahProduk < 1) {
            errors.push('Jumlah produk belum diisi');
        }
        
        // Validasi setiap produk
        for (let i = 1; i <= jumlahProduk; i++) {
            if (!$(`#fk_pdrk_id_${i}`).val()) {
                errors.push(`Produk ${i} belum dipilih`);
            }
            if (!$(`#ordr_it_quantity_${i}`).val() || $(`#ordr_it_quantity_${i}`).val() < 1) {
                errors.push(`Quantity produk ${i} belum diisi atau tidak valid`);
            }
        }
        
        // Validasi total amount
        if (!$('#ordr_total_amount').val() || $('#ordr_total_amount').val() <= 0) {
            errors.push('Total amount tidak valid');
        }
        
        return errors;
    }
    
    // Function untuk highlight error fields
    function highlightErrorFields() {
        // Remove previous highlights
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        
        // Highlight empty required fields
        $('input[required], select[required]').each(function() {
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
            }
        });
    }
</script>