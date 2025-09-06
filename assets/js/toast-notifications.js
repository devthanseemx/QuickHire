function showToast(message, type = 'info', description = '') {
    const icons = {
        success: `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="#16a34a" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                `,
        error: `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="#dc2626" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                `,
        info: `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="#2563eb" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                `
    };

    const toastNode = document.createElement('div');
    toastNode.className = 'flex items-start';

    const iconContainer = document.createElement('div');
    iconContainer.className = 'mr-3 flex-shrink-0';
    iconContainer.innerHTML = icons[type] || icons['info'];

    const textContainer = document.createElement('div');

    const textElement = document.createElement('div');
    textElement.textContent = message;
    textElement.className = 'text-sm text-nowrap font-medium text-gray-900';
    textContainer.appendChild(textElement);

    if (description && description.trim() !== '') {
        const descElement = document.createElement('div');
        descElement.textContent = description;
        descElement.className = 'text-xs text-gray-600 mt-1';
        textContainer.appendChild(descElement);
    }

    toastNode.appendChild(iconContainer);
    toastNode.appendChild(textContainer);

    Toastify({
        node: toastNode,
        duration: 3000,
        gravity: "top",
        position: "right",
        stopOnFocus: true,
        style: {
            background: "#ffffff",
            color: "#1f2937",
            boxShadow: "0 4px 12px rgba(0, 0, 0, 0.1)",
            borderRadius: "8px",
            border: "1px solid #e5e7eb",
            padding: "12px 20px",
            maxWidth: "320px"
        },
        offset: {
            x: 20,
            y: 20
        },
    }).showToast();
}
