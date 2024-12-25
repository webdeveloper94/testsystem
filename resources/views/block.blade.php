<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foydalanuvchi bloklangan</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Modal -->
    <div class="modal fade" id="blockedAlert" tabindex="-1" aria-labelledby="blockedAlertLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="blockedAlertLabel">Foydalanuvchi bloklangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Sizning hisobingiz bloklangan. Iltimos, ma'lumotni tekshiring.
                </div>
                <div class="modal-footer">
                    <!-- Ok tugmasi bosilganda foydalanuvchini log out qiladi va welcome sahifasiga yo'naltiradi -->
                    <button class="btn btn-primary" onclick="logoutAndRedirect()">Ok</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Modalni ochish
        window.onload = function() {
            var myModal = new bootstrap.Modal(document.getElementById('blockedAlert'));
            myModal.show();
        };

        // Logout qilish va welcome sahifasiga yo'naltirish
        function logoutAndRedirect() {
            // Foydalanuvchini logout qilish uchun POST so'rovini yuborish
            fetch("{{ route('logout') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            })
            .then(response => {
                // Foydalanuvchi tizimdan chiqqandan so'ng, welcome sahifasiga yo'naltirish
                window.location.href = "/";
            });
        }
    </script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
</body>
</html>
