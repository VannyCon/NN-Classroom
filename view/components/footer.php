    <!-- Bootstrap JS and dependencies (jQuery and Popper.js) -->
    <script>
        function setDeleteId(button) {
            var id = button.getAttribute('data-id');
            document.getElementById('deleteId').value = id;
            $('#deleteModal').modal('show');
        }
        function setCreateId(button) {
            var id = button.getAttribute('data-id');
            document.getElementById('contentID').value = id;
            $('#createContentModal').modal('show');
        }

        function setEditTimelineData(timelineItem) {
            document.getElementById('edit_timeline_id').value = timelineItem.id;
            document.getElementById('edit_timeline_title').value = timelineItem.timeline_title;
            document.getElementById('edit_history_date').value = timelineItem.history_date;
            $('#editTimelineModal').modal('show');
        }

        function setDeleteTimelineId(id) {
            document.getElementById('delete_timeline_id').value = id;
            $('#deleteModal').modal('show');
        }

        function setEditContentData(contentItem) {
            document.getElementById('edit_content').value = contentItem.content; // Update to match contentItem properties
            document.getElementById('edit_status').value = contentItem.status;   // Update to match contentItem properties
            document.getElementById('edit_id').value = contentItem.id; // Correct hidden input for content ID
            $('#editContentModal').modal('show'); // Show modal
        }
        function setDeleteContent(id) {
            document.getElementById('delete_content_id').value = id;
            $('#deleteContentModal').modal('show');
        }

        document.addEventListener('DOMContentLoaded', function() {
            initializeSearchFilter('searchInput', 'nurseryOwnersTable', 'noRecords');
        });



        ////////////////////////////////////////////////////DROP DOWN//////////////////////////////////////////////////////////////
        // SELECT ORDER DROPDOWN
        function selectOrderPlants(element) {
            var selectedValue = element.innerHTML.trim();
            const selectedId = element.getAttribute('data-id');
            const selectedField = element.getAttribute('data-field');
            document.getElementById("searchOrderPlantsInput").value = selectedValue;
            // Update the hidden input
            document.getElementById('nurseryId').value = selectedId;
            document.getElementById('nurseryField').value = selectedField;
            document.getElementById("orderPlantsDropdownContent").classList.remove("show");
        }

        function toggleOrderPlantsDropdown() {
            document.getElementById("orderPlantsDropdownContent").classList.toggle("show");
        }

        function filterOrderPlantsOptions() {
            filterDropdown("searchOrderPlantsInput", "orderPlantsDropdownContent");
        }


       // SELECT SOURCE DROPDOWN
        function selectSource(element) {
            var selectedValue = element.innerHTML.trim();
            var selectedId = element.getAttribute('data-id');
            document.getElementById("searchSourceInput").value = selectedValue;
            document.getElementById("source_id").value = selectedId;
            document.getElementById("sourceDropdownContent").classList.remove("show");
        }

        function toggleSourceDropdown() {
            document.getElementById("sourceDropdownContent").classList.toggle("show");
        }

        function filterSourceOptions() {
            filterDropdown("searchSourceInput", "sourceDropdownContent");
        }

        // SELECT TYPE DROPDOWN
        function selectType(element) {
            var selectedValue = element.innerHTML.trim();
            var selectedId = element.getAttribute('data-id');
            document.getElementById("searchTypeInput").value = selectedValue;
            document.getElementById("type_id").value = selectedId;
            document.getElementById("typeDropdownContent").classList.remove("show");
        }

        function toggleTypeDropdown() {
            document.getElementById("typeDropdownContent").classList.toggle("show");
        }

        function filterTypeOptions() {
            filterDropdown("searchTypeInput", "typeDropdownContent");
        }

        // SELECT VARIETY DROPDOWN
        function selectVariety(element) {
            var selectedValue = element.innerHTML.trim();
            var selectedId = element.getAttribute('data-id');
            document.getElementById("searchVarietyInput").value = selectedValue;
            document.getElementById("variety_id").value = selectedId;
            document.getElementById("varietyDropdownContent").classList.remove("show");
        }

        function toggleVarietyDropdown() {
            document.getElementById("varietyDropdownContent").classList.toggle("show");
        }

        function filterVarietyOptions() {
            filterDropdown("searchVarietyInput", "varietyDropdownContent");
        }
                
        // General Dropdown Filter
        function filterDropdown(inputId, dropdownContentId) {
            var input, filter, div, i;
            input = document.getElementById(inputId);
            filter = input.value.toUpperCase();
            div = document.getElementById(dropdownContentId).getElementsByTagName("div");

            for (i = 0; i < div.length; i++) {
                txtValue = div[i].textContent || div[i].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    div[i].style.display = "";
                } else {
                    div[i].style.display = "none";
                }
            }
        }

        // Close dropdown when clicking outside
        window.onclick = function(event) {
            if (!event.target.matches('.form-control')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    if (dropdowns[i].classList.contains('show')) {
                        dropdowns[i].classList.remove('show');
                    }
                }
            }
        }

       ////////////////////////////////////////////////////DROP DOWN//////////////////////////////////////////////////////////////

        
       ////////////////////////////////////////////////////SEARCHBAR//////////////////////////////////////////////////////////////
        function initializeSearchFilter(searchInputId, tableId, noRecordsId) {
            document.getElementById(searchInputId).addEventListener('keyup', function() {
                var input, filter, table, tr, td, i, j, txtValue, found;
                input = document.getElementById(searchInputId);
                filter = input.value.toLowerCase();
                table = document.getElementById(tableId);
                tr = table.getElementsByTagName('tr');
                found = false;

                // Loop through all table rows, excluding the header
                for (i = 1; i < tr.length; i++) {
                    tr[i].style.display = "none"; // Hide the row initially

                    // Check if any cell in the row contains the search input value
                    td = tr[i].getElementsByTagName('td');
                    for (j = 0; j < td.length; j++) {
                        if (td[j]) {
                            txtValue = td[j].textContent || td[j].innerText;
                            if (txtValue.toLowerCase().indexOf(filter) > -1) {
                                tr[i].style.display = ""; // Show the row if a match is found
                                found = true;
                                break;
                            }
                        }
                    }
                }

                // Show or hide the 'No records' message
                var noRecords = document.getElementById(noRecordsId);
                if (!found) {
                    noRecords.style.display = "block"; // Show "no records" message if nothing is found
                } else {
                    noRecords.style.display = "none"; // Hide "no records" message if results are found
                }
            });
            
        };
        ////////////////////////////////////////////////////SEARCHBAR//////////////////////////////////////////////////////////////

        
        // // Toggle dropdown visibility
        // function toggleDropdown() {
        //     document.getElementById("dropdownContent").classList.toggle("show");
        // }

        // // Filter dropdown options
        // function filterFunction() {
        //     var input, filter, div, i;
        //     input = document.getElementById("searchInput");
        //     filter = input.value.toUpperCase();
        //     div = document.getElementById("dropdownContent").getElementsByTagName("div");

        //     for (i = 0; i < div.length; i++) {
        //         txtValue = div[i].textContent || div[i].innerText;
        //         if (txtValue.toUpperCase().indexOf(filter) > -1) {
        //             div[i].style.display = "";
        //         } else {
        //             div[i].style.display = "none";
        //         }
        //     }
        // }



        // // Close the dropdown if clicked outside
        // window.onclick = function(event) {
        //     if (!event.target.matches('#searchInput')) {
        //         var dropdowns = document.getElementsByClassName("dropdown-content");
        //         for (var i = 0; i < dropdowns.length; i++) {
        //             if (dropdowns[i].classList.contains('show')) {
        //                 dropdowns[i].classList.remove('show');
        //             }
        //         }
        //     }
        // }

        
        // document.addEventListener('DOMContentLoaded', function () {
        //     const sidebar = document.querySelector('.sidebar');
        //     const toggle = document.querySelector('.sidebar .toggle');

        //     // Check saved state in local storage
        //     const sidebarState = localStorage.getItem('sidebarState');
        //     if (sidebarState === 'open') {
        //         sidebar.classList.remove('close');
        //     } else {
        //         sidebar.classList.add('close');
        //     }

        //     // Add toggle event listener
        //     toggle.addEventListener('click', function () {
        //         if (sidebar.classList.contains('close')) {
        //             sidebar.classList.remove('close');
        //             localStorage.setItem('sidebarState', 'open'); // Save state as open
        //         } else {
        //             sidebar.classList.add('close');
        //             localStorage.removeItem('sidebarState'); // Remove saved state
        //         }
        //     });
        // });
    </script>
    <script src="../../js/sidebar.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
</body>
</html>