document.addEventListener('DOMContentLoaded', () => {
    const fallback = document.body.dataset.placeholder || '/images/placeholder-game.svg';

    document.querySelectorAll('img[data-fallback]').forEach((image) => {
        image.addEventListener('error', () => {
            if (image.src.endsWith('placeholder-game.svg')) return;
            image.src = fallback;
        }, { once: true });
    });

    const mainImage = document.querySelector('[data-main-product-image]');
    document.querySelectorAll('[data-product-thumb]').forEach((thumb) => {
        thumb.addEventListener('click', () => {
            if (!mainImage) return;
            mainImage.src = thumb.dataset.productThumb;
            document.querySelectorAll('[data-product-thumb]').forEach((item) => item.classList.remove('active'));
            thumb.classList.add('active');
        });
    });

    document.querySelectorAll('input[type="file"][multiple]').forEach((input) => {
        input.addEventListener('change', () => {
            const help = input.closest('.mb-3, .col-md-6, .col-12')?.querySelector('[data-file-count]');
            if (help) help.textContent = `${input.files.length} arquivo(s) selecionado(s)`;
        });
    });
});
