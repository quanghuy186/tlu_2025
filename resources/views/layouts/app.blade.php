@include('components.header')

@include('components.nav')

@yield('content')

@include('components.footer')

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        document.getElementById('openProfileModal').addEventListener('click', function(e) {
            e.preventDefault();
            var userModal = new bootstrap.Modal(document.getElementById('userInfoModal'));
            userModal.show();
        });
    });
</script>
</body>
</html>
