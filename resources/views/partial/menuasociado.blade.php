<aside class="main-sidebar">
  
        <section class="sidebar">
          
          <ul class="sidebar-menu">
              <li class="header">MENU</li>
              <li>
                  <a href="/admin/profile">
                    <i class="fa fa-th"></i> <span>Perfil</span>
                  </a>
                </li>
    
              <li>
                <a href="/admin/servicios">
                  <i class="fa fa-th"></i> <span>Servicios</span>
                </a>
              </li>

              <li>
                <a href="/admin/categorias">
                  <i class="fa fa-th"></i> <span>Categorias</span>
                </a>
              </li>

              <li>
                  <a  href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                    <i class="fa fa-th"></i> <span> {{ __('Salir') }}</span>
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      {{ csrf_field() }}
                  </form>
              </li>        
          </ul>
        </section>
     
      </aside>