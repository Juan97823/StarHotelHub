    </div> <!-- Fin del container -->
  </div> <!-- Fin del page-content-wrapper -->
</div> <!-- Fin del wrapper -->

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Dashboard logic -->
<script src="<?= RUTA_PRINCIPAL ?>assets/js/page/dashboard.js"></script>

<!-- Sidebar toggle -->
<script>
  document.getElementById("menu-toggle").addEventListener("click", function () {
    document.getElementById("wrapper").classList.toggle("toggled");
  });
</script>

</body>
</html>
