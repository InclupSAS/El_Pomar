document.addEventListener('DOMContentLoaded', function() {
    function activateTab(tabId) {
        document.querySelectorAll('.tab').forEach(function(link) {
            link.classList.remove('active');
        });

        document.querySelectorAll('.tab-content').forEach(function(content) {
            content.classList.remove('current');
        });

        let tabLink = document.querySelector('.tab[data-tab="' + tabId + '"]');
        let tabContent = document.getElementById(tabId);

        if (tabLink && tabContent) {
            tabLink.classList.add('active');
            tabContent.classList.add('current');

            let firstProductLink = tabContent.querySelector('.product-link');
            if (firstProductLink) {
                firstProductLink.click();
            }
        }
    }

    function updateMetaTags(title, description, image) {
        let metaTitle = document.querySelector('meta[name="title"]');
        let metaDescription = document.querySelector('meta[name="description"]');
        let metaOgTitle = document.querySelector('meta[property="og:title"]');
        let metaOgDescription = document.querySelector('meta[property="og:description"]');
        let metaOgImage = document.querySelector('meta[property="og:image"]');

        if (!metaTitle) {
            metaTitle = document.createElement('meta');
            metaTitle.name = 'title';
            document.head.appendChild(metaTitle);
        }
        if (!metaDescription) {
            metaDescription = document.createElement('meta');
            metaDescription.name = 'description';
            document.head.appendChild(metaDescription);
        }
        if (!metaOgTitle) {
            metaOgTitle = document.createElement('meta');
            metaOgTitle.property = 'og:title';
            document.head.appendChild(metaOgTitle);
        }
        if (!metaOgDescription) {
            metaOgDescription = document.createElement('meta');
            metaOgDescription.property = 'og:description';
            document.head.appendChild(metaOgDescription);
        }
        if (!metaOgImage) {
            metaOgImage = document.createElement('meta');
            metaOgImage.property = 'og:image';
            document.head.appendChild(metaOgImage);
        }

        metaTitle.content = title;
        metaDescription.content = description;
        metaOgTitle.content = title;
        metaOgDescription.content = description;
        metaOgImage.content = image;
    }

    document.querySelectorAll('.tab').forEach(function(tabLink) {
        tabLink.addEventListener('click', function(e) {
            e.preventDefault();
            let tabId = this.getAttribute('data-tab');
            activateTab(tabId);
        });
    });

    document.querySelectorAll('.accordion-header').forEach(function(header) {
        header.addEventListener('click', function() {
            let content = this.nextElementSibling;
            let toggleIcon = this.querySelector('.toggle-icon');
            if (content.style.display === 'block') {
                content.style.display = 'none';
                toggleIcon.src = el_pomar_core.plugin_url + 'assets/img/icons/plus.svg';
            } else {
                content.style.display = 'block';
                toggleIcon.src = el_pomar_core.plugin_url + 'assets/img/icons/minus.svg';
            }
        });
    });

    function loadProductDetails(postId, tabId) {
        let request = new XMLHttpRequest();
        request.open('GET', el_pomar_core.ajax_url + '?action=load_product_details&post_id=' + postId, true);
        request.onload = function() {
            if (this.status >= 200 && this.status < 400) {
                let data = JSON.parse(this.response);
                let tabContent = document.getElementById(tabId);
                let productImage = tabContent.querySelector('#product-image');
                if (productImage) {
                    productImage.src = data.image;
                }
                tabContent.querySelector('.buy-button').href = data.url;
                tabContent.querySelector('#product-name').textContent = data.name; 
                tabContent.querySelector('#product-description').innerHTML = data.content;
                tabContent.querySelector('#product-benefits').innerHTML = data.benefits;
                tabContent.querySelector('#product-presentation').innerHTML = data.presentaciones;

                // Add event listeners to presentation items
                tabContent.querySelectorAll('.presentation-item').forEach(function(item) {
                    item.addEventListener('click', function() {
                        let imageUrl = this.getAttribute('data-image');
                        if (productImage) {
                            productImage.src = imageUrl;
                        }
                    });
                });

                // Update meta tags
                updateMetaTags(data.name, data.content, data.image);
            }
        };
        request.send();
    }

    document.querySelectorAll('.product-link').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            let postId = this.getAttribute('data-post-id');
            let postName = this.getAttribute('data-post-name');
            let tabId = this.closest('.tab-content').id;
            let categoryName = '';

            switch (tabId) {
                case 'tab-El_Pomar':
                    categoryName = 'El_Pomar';
                    break;
                case 'tab-Mulai':
                    categoryName = 'Mulai';
                    break;
                case 'tab-Levelma':
                    categoryName = 'Levelma';
                    break;
            }

            loadProductDetails(postId, tabId);

            // Update meta tags
            let title = this.getAttribute('data-post-title');
            let description = this.getAttribute('data-post-description');
            let image = this.getAttribute('data-post-image');
            updateMetaTags(title, description, image);

            // Update URL
            let newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname + '#' + categoryName + '/' + postName;
            window.history.pushState({ path: newUrl }, '', newUrl);
        });
    });

    let hash = window.location.hash;
    if (hash) {
        let parts = hash.split('/');
        let tabId = 'tab-' + parts[0].replace('#', '');
        let postName = parts[1];
        activateTab(tabId);
        if (postName) {
            let postLink = document.querySelector('.product-link[data-post-name="' + postName + '"]');
            if (postLink) {
                postLink.click();
            }
        }
    } else {
        let firstProductLink = document.querySelector('#tab-El_Pomar .product-link.active');
        if (firstProductLink) {
            firstProductLink.click();
        }
    }
});