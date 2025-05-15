@extends('layouts/admin')

@section('content')
<div class="pagetitle">
    <h1>Bảng điều khiển</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">Bảng điều khiển</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
    <div class="row">

      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">

          <!-- Approved Articles Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card" style="border-left: 5px solid #2eca6a;">
              <div class="card-body">
                <h5 class="card-title">Bài viết đã duyệt</h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="background: #e0f8e9; color: #2eca6a;">
                    <i class="bi bi-check-circle"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{ $count_approved_posts }}</h6>
                    {{-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> --}}
                  </div>
                </div>
              </div>

            </div>
          </div>
          
          <!-- Pending Articles Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card revenue-card" style="border-left: 5px solid #ffb848;">

              <div class="card-body">
                <h5 class="card-title">Bài viết chờ duyệt</h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="background: #fff4d9; color: #ffb848;">
                    <i class="bi bi-hourglass-split"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{ $count_pendding_posts }}</h6>
                    {{-- <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span> --}}
                  </div>
                </div>
              </div>

            </div>
          </div><!-- End Pending Articles Card -->

          <!-- Rejected Articles Card -->
          <div class="col-xxl-4 col-xl-12">
            <div class="card info-card customers-card" style="border-left: 5px solid #ff5a5a;">
              <div class="card-body">
                <h5 class="card-title">Bài viết từ chối</h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="background: #ffecec; color: #ff5a5a;">
                    <i class="bi bi-x-circle"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{ $count_reject_reason_posts }}</h6>
                    {{-- <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span> --}}
                  </div>
                </div>

              </div>
            </div>
          </div><!-- End Rejected Articles Card -->

          <!-- Reports -->
          <div class="col-12">
            <div class="card">
              
              <div class="card-header d-flex justify-content-between align-items-center p-3">
                <h5 class="mb-0">Thống kê báo cáo</h5>
                <div class="view-selector">
                  <div class="btn-group" role="group" aria-label="Tùy chọn xem">
                    <button type="button" class="btn btn-primary active" data-period="daily">
                      <i class="bi bi-calendar-day me-1"></i> Theo ngày
                    </button>
                    <button type="button" class="btn btn-outline-primary" data-period="monthly">
                      <i class="bi bi-calendar-month me-1"></i> Theo tháng
                    </button>
                  </div>
                </div>
              </div>
              
              <style>
                .view-selector .btn {
                  transition: all 0.3s;
                  font-weight: 500;
                }
                .view-selector .btn.active {
                  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                }
                .view-selector .btn-outline-primary:hover {
                  background-color: #f8f9fa;
                  color: #4154f1;
                }
              </style>

              <div class="card-body">
                <h5 class="card-title">Thống kê <span id="chart-period-text">/ Tháng {{ date('m') }} năm {{ date('Y') }}</span></h5>
                <div id="reportsChart"></div>

                <script>
                  document.addEventListener("DOMContentLoaded", () => {
                    // Lấy dữ liệu từ biến PHP được truyền vào view
                    const dailyData = JSON.parse('{!! $dailyDataJson !!}');
                    const monthlyData = JSON.parse('{!! $monthlyDataJson !!}');
                    
                    // Khởi tạo biểu đồ với dữ liệu theo ngày (mặc định)
                    chart = new ApexCharts(document.querySelector("#reportsChart"), {
                      series: [{
                        name: 'Đã duyệt',
                        data: dailyData.approved,
                      }, {
                        name: 'Chờ duyệt',
                        data: dailyData.pending,
                      }, {
                        name: 'Từ chối',
                        data: dailyData.rejected,
                      }],
                      chart: {
                        height: 350,
                        type: 'area',
                        toolbar: {
                          show: false
                        },
                      },
                      markers: {
                        size: 4
                      },
                      colors: ['#2eca6a', '#ffb848', '#ff5a5a'],
                      fill: {
                        type: "gradient",
                        gradient: {
                          shadeIntensity: 1,
                          opacityFrom: 0.3,
                          opacityTo: 0.4,
                          stops: [0, 90, 100]
                        }
                      },
                      dataLabels: {
                        enabled: false
                      },
                      stroke: {
                        curve: 'smooth',
                        width: 2
                      },
                      xaxis: {
                        type: 'datetime',
                        categories: dailyData.dates,
                        labels: {
                          formatter: function(value, timestamp, opts) {
                            const date = new Date(timestamp);
                            return `Ngày ${date.getDate()}`;
                          }
                        }
                      },
                      tooltip: {
                        x: {
                          formatter: function(value, { series, seriesIndex, dataPointIndex, w }) {
                            const date = new Date(value);
                            return `Ngày ${date.getDate()} tháng ${date.getMonth() + 1} năm ${date.getFullYear()}`;
                          }
                        }
                      }
                    });
                    
                    chart.render();

                    // Xử lý khi click vào các nút chuyển đổi chế độ xem
                    document.querySelectorAll('.btn[data-period]').forEach(btn => {
                      btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        
                        // Loại bỏ trạng thái active khỏi tất cả các nút
                        document.querySelectorAll('.btn[data-period]').forEach(el => {
                          el.classList.remove('active');
                          el.classList.remove('btn-primary');
                          el.classList.add('btn-outline-primary');
                        });
                        
                        // Thêm trạng thái active cho nút được chọn
                        this.classList.add('active');
                        this.classList.add('btn-primary');
                        this.classList.remove('btn-outline-primary');
                        
                        const period = this.getAttribute('data-period');
                        
                        if (period === 'daily') {
                          // Cập nhật tiêu đề
                          document.getElementById('chart-period-text').textContent = `/ Tháng ${new Date().getMonth() + 1} năm ${new Date().getFullYear()}`;
                          
                          // Cập nhật dữ liệu biểu đồ
                          chart.updateOptions({
                            xaxis: {
                              categories: dailyData.dates,
                              labels: {
                                formatter: function(value, timestamp, opts) {
                                  const date = new Date(timestamp);
                                  return `Ngày ${date.getDate()}`;
                                }
                              }
                            },
                            tooltip: {
                              x: {
                                formatter: function(value, { series, seriesIndex, dataPointIndex, w }) {
                                  const date = new Date(value);
                                  return `Ngày ${date.getDate()} tháng ${date.getMonth() + 1} năm ${date.getFullYear()}`;
                                }
                              }
                            }
                          });
                          
                          chart.updateSeries([
                            { name: 'Đã duyệt', data: dailyData.approved },
                            { name: 'Chờ duyệt', data: dailyData.pending },
                            { name: 'Từ chối', data: dailyData.rejected }
                          ]);
                        } else if (period === 'monthly') {
                          // Cập nhật tiêu đề
                          document.getElementById('chart-period-text').textContent = `/ Năm ${new Date().getFullYear()}`;
                          
                          // Cập nhật dữ liệu biểu đồ
                          chart.updateOptions({
                            xaxis: {
                              categories: monthlyData.months,
                              labels: {
                                formatter: function(value, timestamp, opts) {
                                  const date = new Date(timestamp);
                                  const monthNames = ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 
                                                      'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'];
                                  return monthNames[date.getMonth()];
                                }
                              }
                            },
                            tooltip: {
                              x: {
                                formatter: function(value, { series, seriesIndex, dataPointIndex, w }) {
                                  const date = new Date(value);
                                  const monthNames = ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 
                                                      'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'];
                                  return `${monthNames[date.getMonth()]} năm ${date.getFullYear()}`;
                                }
                              }
                            }
                          });
                          
                          chart.updateSeries([
                            { name: 'Đã duyệt', data: monthlyData.approved },
                            { name: 'Chờ duyệt', data: monthlyData.pending },
                            { name: 'Từ chối', data: monthlyData.rejected }
                          ]);
                        }
                      });
                    });
                  });
                </script>
              </div>

            </div>
          </div>
        </div>
      </div>
      </div>

    </div>
  </section>

@endsection