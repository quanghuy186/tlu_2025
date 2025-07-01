@extends('layouts/admin')

@section('title')
   Trang quản lý hệ thống trao đổi và tra cứu thông tin nội bộ TLU
@endsection

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
    <!-- Card Statistics -->
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
                  <h6>{{ $count_pending_posts }}</h6>
                </div>
              </div>
            </div>
          </div>
        </div>

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
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Forum Posts Reports Chart -->
        <div class="col-12">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center p-3">
              <h5 class="mb-0">Thống kê bài viết diễn đàn</h5>
              <div class="view-selector">
                <div class="btn-group" role="group" aria-label="Tùy chọn xem">
                  <button type="button" class="btn btn-primary active" data-period="daily" data-chart="forum">
                    <i class="bi bi-calendar-day me-1"></i> Theo ngày
                  </button>
                  <button type="button" class="btn btn-outline-primary" data-period="monthly" data-chart="forum">
                    <i class="bi bi-calendar-month me-1"></i> Theo tháng
                  </button>
                </div>
              </div>
            </div>

            <div class="card-body">
              <h5 class="card-title">Thống kê bài viết <span id="forum-chart-period-text">/ Tháng {{ date('m') }} năm {{ date('Y') }}</span></h5>
              <div id="forumReportsChart"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- User Account Statistics Cards -->
    <div class="col-lg-12">
      <div class="row">
        <div class="col-xxl-6 col-md-6">
          <div class="card info-card sales-card" style="border-left: 5px solid #2eca6a;">
            <div class="card-body">
              <h5 class="card-title">Tài khoản hợp lệ</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="background: #e0f8e9; color: #2eca6a;">
                  <i class="bi bi-person-check"></i>
                </div>
                <div class="ps-3">
                  <h6>{{ $count_account_success }}</h6>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xxl-6 col-md-6">
          <div class="card info-card customers-card" style="border-left: 5px solid #ff5a5a;">
            <div class="card-body">
              <h5 class="card-title">Tài khoản không hợp lệ</h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="background: #ffecec; color: #ff5a5a;">
                  <i class="bi bi-person-x"></i>
                </div>
                <div class="ps-3">
                  <h6>{{ $count_account_error }}</h6>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- User Accounts Reports Chart -->
        <div class="col-12">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center p-3">
              <h5 class="mb-0">Thống kê tài khoản người dùng</h5>
              <div class="view-selector">
                <div class="btn-group" role="group" aria-label="Tùy chọn xem">
                  <button type="button" class="btn btn-primary active" data-period="daily" data-chart="user">
                    <i class="bi bi-calendar-day me-1"></i> Theo ngày
                  </button>
                  <button type="button" class="btn btn-outline-primary" data-period="monthly" data-chart="user">
                    <i class="bi bi-calendar-month me-1"></i> Theo tháng
                  </button>
                </div>
              </div>
            </div>

            <div class="card-body">
              <h5 class="card-title">Thống kê tài khoản <span id="user-chart-period-text">/ Tháng {{ date('m') }} năm {{ date('Y') }}</span></h5>
              <div id="userReportsChart"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>
@endsection

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

<script>
  document.addEventListener("DOMContentLoaded", () => {
    // Parse JSON data
    const dailyData = JSON.parse('{!! $dailyDataJson !!}');
    const monthlyData = JSON.parse('{!! $monthlyDataJson !!}');
    const userDailyData = JSON.parse('{!! $userDailyDataJson !!}');
    const userMonthlyData = JSON.parse('{!! $userMonthlyDataJson !!}');
    
    // Tạo mảng nhãn cho các ngày trong tháng
    const daysInMonth = {{ $data['daysInMonth'] }};
    const currentMonth = {{ $data['currentMonth'] }};
    const currentYear = {{ $data['currentYear'] }};
    const dayLabels = [];
    
    for (let i = 1; i <= daysInMonth; i++) {
      dayLabels.push(`Ngày ${i}`);
    }
    
    const vnMonths = [
      'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
      'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
    ];

    //thống kê diễn đàn
    const forumChart = new ApexCharts(document.querySelector("#forumReportsChart"), {
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
        fontFamily: 'Nunito, sans-serif',
      },
      markers: {
        size: 4,
        hover: {
          size: 6
        }
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
        type: 'category',
        categories: dayLabels,
        tickPlacement: 'on',
        labels: {
          style: {
            fontSize: '12px'
          }
        },
        axisBorder: {
          show: true
        },
        axisTicks: {
          show: true
        }
      },
      yaxis: {
        labels: {
          formatter: function(value) {
            return Math.round(value);
          }
        }
      },
      tooltip: {
        shared: true,
        intersect: false,
        y: {
          formatter: function(value) {
            return value + " bài viết";
          }
        }
      },
      grid: {
        borderColor: '#f1f1f1',
        xaxis: {
          lines: {
            show: false
          }
        }
      },
      legend: {
        position: 'top',
        horizontalAlign: 'right',
        fontSize: '14px'
      }
    });
    
    // Initialize User Accounts Chart
    const userChart = new ApexCharts(document.querySelector("#userReportsChart"), {
      series: [{
        name: 'Tài khoản hợp lệ',
        data: userDailyData.active,
      }, {
        name: 'Tài khoản không hợp lệ',
        data: userDailyData.inactive,
      }],
      chart: {
        height: 350,
        type: 'area',
        toolbar: {
          show: false
        },
        fontFamily: 'Nunito, sans-serif',
      },
      markers: {
        size: 4,
        hover: {
          size: 6
        }
      },
      colors: ['#2eca6a', '#ff5a5a'],
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
        type: 'category',
        categories: dayLabels,
        tickPlacement: 'on',
        labels: {
          style: {
            fontSize: '12px'
          }
        },
        axisBorder: {
          show: true
        },
        axisTicks: {
          show: true
        }
      },
      yaxis: {
        labels: {
          formatter: function(value) {
            return Math.round(value);
          }
        }
      },
      tooltip: {
        shared: true,
        intersect: false,
        y: {
          formatter: function(value) {
            return value + " tài khoản";
          }
        }
      },
      grid: {
        borderColor: '#f1f1f1',
        xaxis: {
          lines: {
            show: false
          }
        }
      },
      legend: {
        position: 'top',
        horizontalAlign: 'right',
        fontSize: '14px'
      }
    });
    
    // Render both charts
    forumChart.render();
    userChart.render();

    // Add event listeners for period toggle buttons
    document.querySelectorAll('.btn[data-period]').forEach(btn => {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        
        const chartType = this.getAttribute('data-chart');
        const period = this.getAttribute('data-period');
        
        // Remove active class from all buttons in the same group
        const buttonGroup = this.closest('.view-selector');
        buttonGroup.querySelectorAll('.btn[data-period]').forEach(el => {
          el.classList.remove('active');
          el.classList.remove('btn-primary');
          el.classList.add('btn-outline-primary');
        });
        
        // Add active class to clicked button
        this.classList.add('active');
        this.classList.add('btn-primary');
        this.classList.remove('btn-outline-primary');
        
        if (chartType === 'forum') {
          // Update forum chart
          if (period === 'daily') {
            document.getElementById('forum-chart-period-text').textContent = `/ Tháng ${currentMonth} năm ${currentYear}`;
            
            forumChart.updateOptions({
              xaxis: {
                categories: dayLabels,
                tickPlacement: 'on'
              }
            });
            
            forumChart.updateSeries([
              { name: 'Đã duyệt', data: dailyData.approved },
              { name: 'Chờ duyệt', data: dailyData.pending },
              { name: 'Từ chối', data: dailyData.rejected }
            ]);
          } else if (period === 'monthly') {
            document.getElementById('forum-chart-period-text').textContent = `/ Năm ${currentYear}`;
            
            forumChart.updateOptions({
              xaxis: {
                categories: vnMonths,
                tickPlacement: 'on'
              }
            });
            
            forumChart.updateSeries([
              { name: 'Đã duyệt', data: monthlyData.approved },
              { name: 'Chờ duyệt', data: monthlyData.pending },
              { name: 'Từ chối', data: monthlyData.rejected }
            ]);
          }
        } else if (chartType === 'user') {
          // Update user chart
          if (period === 'daily') {
            document.getElementById('user-chart-period-text').textContent = `/ Tháng ${currentMonth} năm ${currentYear}`;
            
            userChart.updateOptions({
              xaxis: {
                categories: dayLabels,
                tickPlacement: 'on'
              }
            });
            
            userChart.updateSeries([
              { name: 'Tài khoản hợp lệ', data: userDailyData.active },
              { name: 'Tài khoản không hợp lệ', data: userDailyData.inactive }
            ]);
          } else if (period === 'monthly') {
            document.getElementById('user-chart-period-text').textContent = `/ Năm ${currentYear}`;
            
            userChart.updateOptions({
              xaxis: {
                categories: vnMonths,
                tickPlacement: 'on'
              }
            });
            
            userChart.updateSeries([
              { name: 'Tài khoản hợp lệ', data: userMonthlyData.active },
              { name: 'Tài khoản không hợp lệ', data: userMonthlyData.inactive }
            ]);
          }
        }
      });
    });
  });
</script>