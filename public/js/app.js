document.addEventListener("DOMContentLoaded", function () {
    // Initialize AOS
    AOS.init({
        duration: 800,
        once: true,
        offset: 100,
    });

    // Back to top button
    const backToTop = document.getElementById('back-to-top');
    if (backToTop) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                backToTop.style.display = 'block';
            } else {
                backToTop.style.display = 'none';
            }
        });
        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
    // Password Visibility Toggle
    document.querySelectorAll('[data-toggle-password]').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-toggle-password');
            const passwordInput = document.getElementById(targetId);
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    });

    // Wishlist Toggle
    document.querySelectorAll('.toggle-wishlist').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');
            const icon = this.querySelector('i');
            
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            
            fetch('/wishlist/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfMeta ? csrfMeta.getAttribute('content') : '',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(response => {
                if (response.status === 401) {
                    window.location.href = '/login';
                    return null;
                }
                return response.json();
            })
            .then(data => {
                if (!data) return;
                
                const badge = document.querySelector('.wishlist-count-badge');
                let count = badge ? parseInt(badge.innerText) : 0;

                if (data.status === 'added') {
                    icon.classList.remove('far', 'text-muted');
                    icon.classList.add('fas', 'text-danger');
                    if (badge) badge.innerText = count + 1;
                } else if (data.status === 'removed') {
                    icon.classList.remove('fas', 'text-danger');
                    icon.classList.add('far');
                    if (!this.classList.contains('btn-outline-secondary')) {
                        icon.classList.add('text-muted');
                    }
                    if (badge && count > 0) badge.innerText = count - 1;
                }
            })
            .catch(error => {
                console.error('Error toggling wishlist:', error);
            });
        });
    });

    // Add to Cart Handlers
    function handleAddToCart(productId, quantity = 1, button = null) {
        const csrfMeta = document.querySelector('meta[name="csrf-token"]');
        
        if (button) {
            button.disabled = true;
            button.classList.add('opacity-75');
        }

        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfMeta ? csrfMeta.getAttribute('content') : '',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ product_id: productId, quantity: quantity })
        })
        .then(async res => {
            if (!res.ok) {
                const text = await res.text();
                try {
                    return JSON.parse(text);
                } catch(e) {
                    throw new Error("Server error occurred. Please try again.");
                }
            }
            return res.json();
        })
        .then(data => {
            if (data.error) {
                alert(data.error);
                return;
            }
            
            if (data.success && data.count !== undefined) {
                const badges = document.querySelectorAll('.cart-count-badge');
                badges.forEach(b => b.innerText = data.count);
                
                if(button) {
                    const originalContent = button.innerHTML;
                    button.innerHTML = '<i class="fas fa-check me-2"></i> Added!';
                    button.classList.add('btn-success');
                    button.classList.remove('btn-primary-custom');
                    setTimeout(() => {
                        button.innerHTML = originalContent;
                        button.classList.remove('btn-success');
                        button.classList.add('btn-primary-custom');
                        button.disabled = false;
                        button.classList.remove('opacity-75');
                    }, 2000);
                }
            }
        })
        .catch(err => {
            console.error("Error adding to cart: ", err);
            alert(err.message || "Could not add item to cart. Please check your connection.");
            if (button) {
                button.disabled = false;
                button.classList.remove('opacity-75');
            }
        });
    }

    // Grid cards
    document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            if(this.classList.contains('disabled')) return;
            const pid = this.getAttribute('data-product-id');
            handleAddToCart(pid, 1, this);
        });
    });

    // Detail page form
    const addToCartForm = document.getElementById('addToCartForm');
    if (addToCartForm) {
        addToCartForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const pid = this.getAttribute('data-product-id');
            const qtyInput = document.getElementById('qtyInput');
            const qty = qtyInput ? parseInt(qtyInput.value) : 1;
            const btn = this.querySelector('button[type="submit"]');
            if(btn && btn.classList.contains('disabled')) return;
            handleAddToCart(pid, qty, btn);
        });
    }
});
