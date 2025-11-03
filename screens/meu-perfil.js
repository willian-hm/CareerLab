document.querySelectorAll('.btn-excluir').forEach(btn => {
    btn.addEventListener('click', async () => {
        if (!confirm('Deseja realmente excluir esta postagem?')) return;

        const card = btn.closest('.post-card');
        const idpostagem = card.dataset.id;

        try {
            const res = await fetch('excluir-post.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ idpostagem })
            });

            const data = await res.json();

            if (data.sucesso) {
                card.remove();
            } else {
                alert(data.error || 'Erro ao excluir postagem');
            }
        } catch (err) {
            console.error(err);
            alert('Erro ao excluir postagem');
        }
    });
});
