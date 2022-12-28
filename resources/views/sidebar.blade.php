<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <!-- Styles -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

  <!-- Icon -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

  <style>
    .bi {
      vertical-align: -.125em;
    }

    .active {
      background-color: brown !important;
    }

    .sidebar {
      min-height: 100vh;
    }
  </style>
</head>

<body>
  <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="house-fill" viewBox="0 0 16 16">
      <path
        d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5Z" />
      <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6Z" />
    </symbol>
    <symbol id="home" viewBox="0 0 16 16">
      <path
        d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5z">
      </path>
    </symbol>
    <symbol id="out" viewBox="0 0 16 16">
      <path fill-rule="evenodd"
        d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z" />
      <path fill-rule="evenodd"
        d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
    </symbol>
    <symbol id="percent" viewBox="0 0 16 16">
      <path
        d="M13.442 2.558a.625.625 0 0 1 0 .884l-10 10a.625.625 0 1 1-.884-.884l10-10a.625.625 0 0 1 .884 0zM4.5 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5zm7 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z" />
    </symbol>
    <symbol id="pie" viewBox="0 0 16 16">
      <path
        d="M7.5 1.018a7 7 0 0 0-4.79 11.566L7.5 7.793V1.018zm1 0V7.5h6.482A7.001 7.001 0 0 0 8.5 1.018zM14.982 8.5H8.207l-4.79 4.79A7 7 0 0 0 14.982 8.5zM0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8z" />
    </symbol>
    <symbol id="people" viewBox="0 0 16 16">
      <path
        d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z" />
    </symbol>
    <symbol id="setting" viewBox="0 0 16 16">
      <path
        d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z" />
      <path
        d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z" />
    </symbol>
    <symbol id="balloon" viewBox="0 0 16 16">
      <path fill-rule="evenodd"
        d="M8 9.984C10.403 9.506 12 7.48 12 5a4 4 0 0 0-8 0c0 2.48 1.597 4.506 4 4.984ZM13 5c0 2.837-1.789 5.227-4.52 5.901l.244.487a.25.25 0 1 1-.448.224l-.008-.017c.008.11.02.202.037.29.054.27.161.488.419 1.003.288.578.235 1.15.076 1.629-.157.469-.422.867-.588 1.115l-.004.007a.25.25 0 1 1-.416-.278c.168-.252.4-.6.533-1.003.133-.396.163-.824-.049-1.246l-.013-.028c-.24-.48-.38-.758-.448-1.102a3.177 3.177 0 0 1-.052-.45l-.04.08a.25.25 0 1 1-.447-.224l.244-.487C4.789 10.227 3 7.837 3 5a5 5 0 0 1 10 0Zm-6.938-.495a2.003 2.003 0 0 1 1.443-1.443C7.773 2.994 8 2.776 8 2.5c0-.276-.226-.504-.498-.459a3.003 3.003 0 0 0-2.46 2.461c-.046.272.182.498.458.498s.494-.227.562-.495Z" />
    </symbol>
  </svg>
  <div class="container-fluid">
    <div class="row">
      <nav id="sidebar" class="col-md-1 col-lg-1 d-md-block sidebar collpase border rounded">
        <div class="d-flex flex-nowrap">
          <div class="d-flex flex-column flex-shrink-0" style="width: 4.5rem;">
            <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">
              <a href="/" class="d-block p-3 link-dark text-decoration-none" data-bs-toggle="tooltip"
                data-bs-placement="right" data-bs-original-title="Icon-only">
                <svg fill="brown" class="bi pe-none" width="40" height="32">
                  <use xlink:href="#house-fill"></use>
                </svg>
                <span class="visually-hidden">Icon-only</span>
              </a>
              <li class="nav-item">
                <a href="#" class="nav-link py-3 rounded-0" aria-current="page" data-bs-toggle="tooltip"
                  data-bs-placement="right" aria-label="Home" data-bs-original-title="Home">
                  <svg fill="brown" class="bi pe-none" width="24" height="24" role="img" aria-label="Home">
                    <use xlink:href="#home"></use>
                  </svg>
                  <span style="color: gray">Discount</span>
                </a>
              </li>
              <li>
                <a href="#" class="nav-link py-3 rounded-0" data-bs-toggle="tooltip" data-bs-placement="right"
                  aria-label="Dashboard" data-bs-original-title="Dashboard">
                  <svg fill="brown" class="bi pe-none" width="24" height="24" role="img" aria-label="Dashboard">
                    <use xlink:href="#percent"></use>
                  </svg>
                  <span style="color: gray">Discount</span>
                </a>
              </li>
              <li>
                <a href="#" class="nav-link py-3 rounded-0" data-bs-toggle="tooltip" data-bs-placement="right"
                  aria-label="Orders" data-bs-original-title="Orders">
                  <svg fill="brown" class="bi pe-none" width="24" height="24" role="img" aria-label="Orders">
                    <use xlink:href="#pie"></use>
                  </svg>
                  <span style="color: gray">Report</span>
                </a>
              </li>
              <li>
                <a href="#" class="nav-link py-3 rounded-0" data-bs-toggle="tooltip" data-bs-placement="right"
                  aria-label="Products" data-bs-original-title="Products">
                  <svg fill="brown" class="bi pe-none" width="24" height="24" role="img" aria-label="Products">
                    <use xlink:href="#people"></use>
                  </svg>
                  <span style="color: gray">Member</span>
                </a>
              </li>
              <li>
                <a href="#" class="nav-link py-3 rounded-0" data-bs-toggle="tooltip" data-bs-placement="right"
                  aria-label="Customers" data-bs-original-title="Customers">
                  <svg fill="brown" class="bi pe-none" width="24" height="24" role="img" aria-label="Customers">
                    <use xlink:href="#balloon"></use>
                  </svg>
                  <span style="color: gray">Birthday</span>
                </a>
              </li>
              <li>
                <div class="py-3">
                  <a href="#" class="btn btn-danger rounded" data-bs-toggle="tooltip" data-bs-placement="right"
                    aria-label="Setting" data-bs-original-title="Setting">
                    <svg fill="white" class="bi pe-none" width="24" height="24" role="img" aria-label="Setting">
                      <use xlink:href="#setting"></use>
                    </svg>
                  </a>
                </div>
              </li>
              <div class="dropdown py-3">
                <a href="#" class="d-flex align-items-center justify-content-center p-3 link-dark text-decoration-none"
                  data-bs-toggle="dropdown" aria-expanded="false">
                  <svg fill="brown" class="bi pe-none" width="24" height="24" role="img">
                    <use xlink:href="#out"></use>
                  </svg>
                </a>
                <ul class="dropdown-menu text-small shadow" style="">
                  <li><a class="dropdown-item" href="#">New project...</a></li>
                  <li><a class="dropdown-item" href="#">Settings</a></li>
                  <li><a class="dropdown-item" href="#">Profile</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item" href="#">Sign out</a></li>
                </ul>
              </div>
            </ul>
          </div>
        </div>
      </nav>
      <main class="col-md-10 col-lg-10">
        <nav class="navbar">
          <div class="container-fluid">
            <h1 class="h3" style="color: brown">Settings</h1>
          </div>
        </nav>
        <div class="d-flex bg-light w-25 p-3 border rounded">
          <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
              <a href="#" class="nav-link link-dark active" aria-current="page">
                <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
                <span>จัดการรายการขาย</span>
              </a>
            </li>
            <li>
              <a href="#" class="nav-link link-dark">
                <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
                จัดการเงินสด
              </a>
            </li>
            <li>
              <a href="#" class="nav-link link-dark">
                <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
                การชำระเงิน
              </a>
            </li>
            <li>
              <a href="#" class="nav-link link-dark">
                <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
                จัดการใบเสร็จ
              </a>
            </li>
            <li>
              <a href="#" class="nav-link link-dark">
                <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
                About Us
              </a>
            </li>
          </ul>
        </div>
      </main>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"
    integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous">
  </script>
</body>

</html>

<!--
    <div class="row">
      <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collpase">
        <div class="position-sticky">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a href="#" class="nav-link active" aria-current="page">
                <i class="bi bi-house-fill"></i>
                <span class="ml-2">Discont</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link" aria-current="page">
                <i class="bi bi-house-fill"></i>
                <span class="ml-2">Discont</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link" aria-current="page">
                <i class="bi bi-house-fill"></i>
                <span class="ml-2">Report</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link" aria-current="page">
                <i class="bi bi-house-fill"></i>
                <span class="ml-2">Member</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link" aria-current="page">
                <i class="bi bi-house-fill"></i>
                <span class="ml-2">Birthday</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link" aria-current="page">
                <i class="bi bi-house-fill"></i>
                <span class="ml-2">Home</span>
              </a>
            </li>
          </ul>
        </div>
      </nav>

      <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-4">
        <h2>Setting</h1>
      </main>
    </div>
  -->