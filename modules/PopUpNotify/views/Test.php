<?
class PopUpNotify_Test_View extends Vtiger_Index_View {

        public function process(Vtiger_Request $request) {
            echo "hwoll world";
            ?>
            <link type="text/css" rel="stylesheet" href="../libraries/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
            <link type="text/css" rel="stylesheet" href="/libraries/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
        
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="">
                  <div class="">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Position</th>
                          <th>Office</th>
                          <th>Age</th>
                          <th>Start date</th>
                          <th>Salary</th>
                        </tr>
                      </thead>
                      <tfoot id="minmn">
                        <tr>
                          <th>Name</th>
                          <th>Position</th>
                          <th>Office</th>
                          <th>Age</th>
                          <th>Start date</th>
                          <th>Salary</th>
                        </tr>
                      </tfoot>


                      <tbody>
                        <tr>
                          <td>Tiger Nixon</td>
                          <td>System Architect</td>
                          <td>Edinburgh</td>
                          <td>61</td>
                          <td>2011/04/25</td>
                          <td>$320,800</td>
                        </tr>
                        <tr>
                          <td>Finn Camacho</td>
                          <td>Support Engineer</td>
                          <td>San Francisco</td>
                          <td>47</td>
                          <td>2009/07/07</td>
                          <td>$87,500</td>
                        </tr>
                        <tr>
                          <td>Serge Baldwin</td>
                          <td>Data Coordinator</td>
                          <td>Singapore</td>
                          <td>64</td>
                          <td>2012/04/09</td>
                          <td>$138,575</td>
                        </tr>
                        <tr>
                          <td>Zenaida Frank</td>
                          <td>Software Engineer</td>
                          <td>New York</td>
                          <td>63</td>
                          <td>2010/01/04</td>
                          <td>$125,250</td>
                        </tr>
                        <tr>
                          <td>Zorita Serrano</td>
                          <td>Software Engineer</td>
                          <td>San Francisco</td>
                          <td>56</td>
                          <td>2012/06/01</td>
                          <td>$115,000</td>
                        </tr>
                        <tr>
                          <td>Jennifer Acosta</td>
                          <td>Junior Javascript Developer</td>
                          <td>Edinburgh</td>
                          <td>43</td>
                          <td>2013/02/01</td>
                          <td>$75,650</td>
                        </tr>
                        <tr>
                          <td>Cara Stevens</td>
                          <td>Sales Assistant</td>
                          <td>New York</td>
                          <td>46</td>
                          <td>2011/12/06</td>
                          <td>$145,600</td>
                        </tr>
                        <tr>
                          <td>Hermione Butler</td>
                          <td>Regional Director</td>
                          <td>London</td>
                          <td>47</td>
                          <td>2011/03/21</td>
                          <td>$356,250</td>
                        </tr>
                        <tr>
                          <td>Lael Greer</td>
                          <td>Systems Administrator</td>
                          <td>London</td>
                          <td>21</td>
                          <td>2009/02/27</td>
                          <td>$103,500</td>
                        </tr>
                        <tr>
                          <td>Jonas Alexander</td>
                          <td>Developer</td>
                          <td>San Francisco</td>
                          <td>30</td>
                          <td>2010/07/14</td>
                          <td>$86,500</td>
                        </tr>
                        <tr>
                          <td>Shad Decker</td>
                          <td>Regional Director</td>
                          <td>Edinburgh</td>
                          <td>51</td>
                          <td>2008/11/13</td>
                          <td>$183,000</td>
                        </tr>
                        <tr>
                          <td>Michael Bruce</td>
                          <td>Javascript Developer</td>
                          <td>Singapore</td>
                          <td>29</td>
                          <td>2011/06/27</td>
                          <td>$183,000</td>
                        </tr>
                        <tr>
                          <td>Donna Snider</td>
                          <td>Customer Support</td>
                          <td>New York</td>
                          <td>27</td>
                          <td>2011/01/25</td>
                          <td>$112,000</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
                  <!-- Datatables -->
                  <script src="/libraries/datatables.net/js/jquery.dataTables.min.js"></script>
                  <script src="/libraries/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
                  <script src="/libraries/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
                  <script src="/libraries/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
                  <script src="/libraries/datatables.net-buttons/js/buttons.html5.min.js"></script>
                  <script src="/libraries/datatables.net-buttons/js/buttons.print.min.js"></script>
                  <script src="/libraries/datatables.net-buttons/js/buttons.html5.min.js"></script>
                  <script src="/libraries/datatables.net-buttons/js/buttons.colVis.js"></script>
                  
                  
             
              
              <script>
             $(document).ready(function() {
          var handleDataTableButtons = function() {
          if ($("#datatable-buttons").length) {
            $("#datatable-buttons").DataTable({
              dom: "Bfrtip",
              buttons: [
                {
                  extend: "copy",
                  className: "btn-sm"
                },
                {
                  extend: "csv",
                  className: "btn-sm"
                },
                {
                  extend: "excel",
                  className: "btn-sm"
                },
                {
                  extend: "pdfHtml5",
                  className: "btn-sm"
                },
                {
                  extend: "print",
                  className: "btn-sm",
                  exportOptions: {
                    columns: ':visible'
                }
                },
                {
                  extend: "colvis",
                  className: "btn-sm",
                  targets: -1,
                  visible: false
        
                }
              ],
              responsive: true
            });
          }
        };

        TableManageButtons = function() {
          "use strict";
          return {
            init: function() {
              handleDataTableButtons();
            }
          };
        }();
        TableManageButtons.init();
     $("#datatable-buttons tfoot").css({"display":"table-header-group"});
     $('#datatable-buttons tfoot th').each( function (){
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder=" Search in '+title+'" />' );
    });

        var table = $('#datatable-buttons').DataTable();
    // Apply the search
    table.columns().every( function (){
        var that = this;
        $('input' , this.footer()).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search(this.value)
                    
                    .draw();
            }
        });
    });
      });
    </script>
              <?php

            
        }
}