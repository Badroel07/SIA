{{-- ========================================================================= --}}
{{-- ALPINE.JS DATA BLOCK UTAMA (Keranjang + Notifikasi) --}}
{{-- ========================================================================= --}}
<div x-data="{ 
    // State Keranjang
    cart: JSON.parse(sessionStorage.getItem('simCart')) || [],
    showCart: false,
    showConfirmClear: false,
    
    // State Toast Notification - DIUBAH JADI ARRAY
    toasts: [],
    toastId: 0, // ID unik untuk setiap toast

    // Fungsi Keranjang
    get cartTotal() {
        return this.cart.reduce((total, item) => total + (item.price * item.qty), 0);
    },
    
    get cartTotalQty() {
        return this.cart.reduce((total, item) => total + item.qty, 0);
    },
    
    saveCart() {
        sessionStorage.setItem('simCart', JSON.stringify(this.cart));
    },

    addToCart(item, qty = 1) {
        const index = this.cart.findIndex(i => i.id === item.id);
        
        if (index > -1) {
            this.cart[index].qty += qty;
        } else {
            this.cart.push({...item, qty: qty});
        }
        
        this.saveCart();
        this.showToast(`${item.name} berhasil ditambahkan!`, 'success');
    },
    
    updateQty(id, change) {
        const index = this.cart.findIndex(i => i.id === id);
        if (index > -1) {
            let newQty = this.cart[index].qty + change;
            
            if (newQty <= 0) {
                this.removeItem(id);
                this.showToast(`Item dihapus dari keranjang.`, 'info');
            } else {
                this.cart[index].qty = newQty;
                this.saveCart();
            }
        }
    },
    
    removeItem(id) {
        this.cart = this.cart.filter(item => item.id !== id);
        this.saveCart();
    },

    // Fungsi Toast Baru - DIUBAH UNTUK SUPPORT MULTIPLE TOASTS
    showToast(message, type) {
        const id = this.toastId++;
        this.toasts.push({
            id: id,
            message: message,
            type: type,
            show: false // Mulai dengan false untuk trigger animasi
        });
        
        // Trigger animasi dengan delay kecil
        setTimeout(() => {
            const toast = this.toasts.find(t => t.id === id);
            if (toast) toast.show = true;
        }, 10);
        
        // Auto remove setelah 3 detik
        setTimeout(() => {
            this.removeToast(id);
        }, 3000);
    },

    removeToast(id) {
        const index = this.toasts.findIndex(t => t.id === id);
        if (index > -1) {
            this.toasts[index].show = false;
            // Hapus dari array setelah animasi selesai
            setTimeout(() => {
                this.toasts = this.toasts.filter(t => t.id !== id);
            }, 300);
        }
    },

    confirmClear() {
        this.showCart = false;
        this.showConfirmClear = true;
    },

    clearCartConfirmed() {
        this.cart = [];
        this.saveCart();
        this.showConfirmClear = false;
        this.showToast('Keranjang berhasil dikosongkan.', 'warning');
    }
}" x-init="cart.length === 0 ? [] : saveCart()" x-cloak>