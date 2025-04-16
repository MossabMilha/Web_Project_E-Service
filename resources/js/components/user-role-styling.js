const roles = document.querySelectorAll('.role');

for (const role of roles) {
    switch (role.textContent.trim().toLowerCase()) {
        case 'admin':
            role.style.background = 'var(--bg-gradient-light)';
            role.style.color = 'var(--color-primary-darker)';
            break;
        case 'professor':
            role.style.backgroundColor = 'var(--color-secondary-light)';
            role.style.color = 'var(--color-secondary-darker)';
            break;
        case 'department_head':
            role.style.backgroundColor = 'var(--color-tirnary-light)';
            role.style.color = 'var(--color-tirnary-darker)';
            break;
        case 'vacataire':
            role.style.backgroundColor = 'var(--color-gray-light)';
            role.style.color = 'var(--color-gray)';
            break;
        case 'coordinator':
            role.style.backgroundColor = 'var(--color-primary-lighter)';
            role.style.color = 'var(--color-primary-darker)';
            break;
    }
    role.style.padding = '0.25em 1em';
    role.style.borderRadius = '1em';
}
