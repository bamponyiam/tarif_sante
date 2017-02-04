    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true,
			"paging":   false
        });
		
		$('#dataTables-plan').DataTable({
            responsive: true,
			"paging":   false,
			"order": [[ 1, "asc" ]],
			"columnDefs": [
				{ "orderable": false, "targets": 0 },
				{ "orderable": false, "targets": 4 }
			  ]
        });
		$('#dataTables-family').DataTable({
            responsive: true,
			"paging":   false,
			"order": [[ 1, "asc" ]],
			"columnDefs": [
				{ "orderable": false, "targets": 0 }
			  ]
        });
		$('#dataTables-quotes').DataTable({
            responsive: true,
			"order": [[ 0, "desc" ]],
			"lengthMenu": [[20, 40, 60, -1], [20, 40, 60, "All"]]
        });
    });
    </script>

</body>

</html>