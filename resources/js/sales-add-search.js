document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const items = document.querySelectorAll('.product-item');
    let debounceTimeout = null;

    searchInput.addEventListener('input', () => {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(() => {
            const keyword = searchInput.value.toLowerCase();
            items.forEach(item => {
                const name = item.getAttribute('data-name');
                item.classList.toggle("hidden", !keyword || !name.includes(keyword));

            });
        }, 300);
    });
});