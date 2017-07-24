var file_id;
			function buildTable(id)
			{
				file_id = id;
				$("#table").load("table.php",
				{
					file_id:file_id
				});
			}
			function buildArchive()
			{
				$("#archivePanel").load("archive.php",
					function()
					{
						$('.archiveItem').on('click',function()
						{
							var id = this.id;
							id  = id.substr(1);

							buildTable(id);
						});
					});
			}


			$(window).on('load', function()
				{buildArchive();
				});