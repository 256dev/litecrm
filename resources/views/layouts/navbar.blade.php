<nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'LiteCRM') }}
        </a>
        @auth
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        @endauth
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @auth
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                @can('viewAny', App\Models\Order::class)
                    <li class="nav-item">
                        <a  href="{{route('orders.index')}}" class="nav-link" href="#" id="navbarDropdown" role="button">
                            <i class="fas fa-list-ul align-bottom"></i>
                            <span>Заказы</span>
                        </a>
                    </li>
                @endcan
                @can('viewAny', App\Models\Customer::class)
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="{{route('customers.index')}}" id="navbarDropdown" role="button">
                            <i class="fas fa-users align-bottom"></i>
                            <span>Клиенты</span>
                        </a>
                    </li>
                @endcan
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link" href="{{route('dashboard')}}" id="navbarDropdown" role="button">
                        <i class="fas fa-chart-line align-bottom"></i>
                        <span>Отчеты</span>
                    </a>
                </li> --}}
                @can('viewAny', App\Models\User::class)
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="{{route('users.index')}}" id="navbarDropdown" role="button">
                            <i class="fas fa-users-cog align-bottom"></i>
                            <span>Сотрудники</span>
                        </a>
                    </li>
                @endcan
                <li class="nav-item dropdown" id="another_items_navbar">
                    <a id="navbarDropdown" class="nav-link" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">
                        <i class="fas fa-chevron-down align-middle"></i>
                        <span>Ещё</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                        @can('viewAny', App\Models\AppSettings::class)
                            <a class="dropdown-item" href="{{route('settings.show')}}">
                                <i class="fas fa-cogs align-bottom mr-2"></i>
                                <span>Настройки</span>
                            </a>
                        @endcan

                        @can('viewAny', App\Models\DeviceModel::class)
                            <a class="dropdown-item" href="{{route('devicemodels.index')}}">
                                <i class="fas fa-laptop-house"></i>
                                <span>Модели устройств</span>
                            </a>
                        @endcan

                        @can('viewAny', App\Models\TypeDevice::class)
                            <a class="dropdown-item" href="{{route('typedevices.index')}}">
                                <i class="fas fa-desktop align-bottom mr-2"></i>
                                <span>Типы устройств</span>
                            </a>
                        @endcan

                        @can('viewAny', App\Models\Manufacturer::class)
                            <a class="dropdown-item" href="{{route('manufacturers.index')}}">
                                <i class="fas fa-industry align-bottom mr-2"></i>
                                <span>Бренды</span>    
                            </a>
                        @endcan

                        @can('viewAny', App\Models\TypeService::class)
                            <a class="dropdown-item" href="{{route('typeservices.index')}}">
                                <i class="fas fa-tools align-bottom mr-2"></i>
                                <span>Услуги</span>    
                            </a>
                        @endcan

                        @can('viewAny', App\Models\TypeRepairPart::class)
                            <a class="dropdown-item" href="{{route('typerepairparts.index')}}">
                                <i class="fas fa-microchip align-bottom mr-2"></i>
                                <span>Материалы</span>    
                            </a>
                        @endcan

                        @can('viewAny', App\Models\Defect::class)
                            <a class="dropdown-item" href="{{route('defects.index')}}">
                                <i class="fas fa-frown align-bottom mr-2"></i>
                                {{-- <i class="far fa-frown-open"></i> --}}
                                <span>Причины обращения</span>    
                            </a>
                        @endcan

                        @can('viewAny', App\Models\Condition::class)
                            <a class="dropdown-item" href="{{route('conditions.index')}}">
                                <i class="fas fa-heartbeat align-bottom mr-2"></i>
                                <span>Состояния</span>    
                            </a>
                        @endcan

                        @can('viewAny', App\Models\Equipment::class)
                            <a class="dropdown-item" href="{{route('equipments.index')}}">
                                <i class="fas fa-shopping-cart align-bottom mr-2"></i>
                                <span>Комплектация</span>    
                            </a>
                        @endcan

                        <script>
                            let another_items_navbar = document.getElementById('another_items_navbar')
                            console.log(another_items_navbar)
                            if (!another_items_navbar.hasChildNodes()) {
                                another_items_navbar.remove()
                                console.log('sda')
                            }
                        </script>

                    </div>
                </li>
            </ul>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <img src="/img/3.png" class="avatar my-auto mr-md-2 d-none d-md-block" alt="Avatar">
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link " role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#" v-pre>
                        <i class="fas fa-chevron-down "></i>
                        <span>{{ Auth::user()->name }}</span>

                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a href="{{ route('settings.user.show') }}" class="dropdown-item">
                            <i class="fas fa-user-cog align-bottom mr-2"></i>
                            <span>Настройки</span>
                        </a>
                        <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt align-bottom mr-2"></i>
                            <span>{{ __('Logout') }}</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
            @endauth
        </div>
    </div>
</nav>
