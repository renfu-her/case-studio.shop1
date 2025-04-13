// 目錄結構交互
document.addEventListener('DOMContentLoaded', function() {
    const categoryLinks = document.querySelectorAll('.widget_categories li a');
    
    categoryLinks.forEach(link => {
        const toggleIcon = link.querySelector('.toggle-icon');
        if (toggleIcon) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                const subCategories = this.nextElementSibling;
                if (subCategories && subCategories.classList.contains('sub-categories')) {
                    const isOpen = subCategories.classList.contains('show');
                    
                    // 切換當前子目錄
                    subCategories.classList.toggle('show');
                    toggleIcon.classList.toggle('open');
                    
                    // 如果是在關閉操作，同時關閉所有子目錄
                    if (isOpen) {
                        const childSubCategories = subCategories.querySelectorAll('.sub-categories');
                        childSubCategories.forEach(child => {
                            child.classList.remove('show');
                            const childToggle = child.previousElementSibling.querySelector('.toggle-icon');
                            if (childToggle) {
                                childToggle.classList.remove('open');
                            }
                        });
                    }
                } else {
                    // 如果沒有子目錄，直接跳轉
                    window.location.href = this.href;
                }
            });
        }
    });
}); 