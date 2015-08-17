<?php
    // get primary navigation menu items
    if (Auth::check()) {
        $menu = Menu::where('level','<=',Auth::user()->level)->where('visibility','1')->orderBy('order','ASC')->get();
    } else {
        $menu = Menu::where('level','==',0)->where('visibility','1')->orderBy('order','ASC')->get();
    }

?>

<!doctype html>
<html class="no-js" lang="sl">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="Blaž Žerko || b-zerko.com">
      <meta name="_token" content="{{ csrf_token() }}"/>
    <title>Iskra Sistemi | Dobrodošli</title>
    {{ HTML::style('/css/foundation.css') }}
    {{ HTML::style('/css/foundation-icons.css') }}
    {{ HTML::style('/css/layout.css') }}
    {{ HTML::style('/slick/slick.css') }}
    {{ HTML::style('/css/jquery.fileupload.css') }}
    {{ HTML::style('/css/iskra.custom.css') }}
    {{ HTML::script('/js/vendor/modernizr.js') }}
    {{ HTML::script('/js/vendor/jquery.js') }}
    {{ HTML::script('/js/vendor/jquery.ui.widget.js') }}
    {{ HTML::script('/js/vendor/jquery-ui.min.js') }}
    {{ HTML::script('/js/foundation.min.js') }}
    {{ HTML::script('/slick/slick.min.js')}}
    {{ HTML::script('/ckeditor/ckeditor.js') }}
    {{ HTML::script('/ckeditor/adapters/jquery.js') }}
    {{ HTML::script('/js/load-image.all.min.js') }}
    {{ HTML::script('/js/canvas-to-blob.min.js') }}
    {{ HTML::script('/js/jquery.knob.js') }}
    {{ HTML::script('/js/jquery.iframe-transport.js') }}
    {{ HTML::script('/js/jquery.fileupload.js') }}
    {{ HTML::script('/js/jquery.fileupload-process.js') }}
    {{ HTML::script('/js/jquery.fileupload-image.js') }}
    {{ HTML::script('/js/jquery.fileupload-audio.js') }}
    {{ HTML::script('/js/jquery.fileupload-video.js') }}
    {{ HTML::script('/js/jquery.fileupload-validate.js') }}

    {{ HTML::script('http://maps.googleapis.com/maps/api/js?key=AIzaSyAcGmw4pGsY0YicHaFQJtjb0HKeh0LsxiU') }}

      <script language="JavaScript">
          $(document).ready(function() {
              $('a#modalLink').click( function(e) {
                  e.preventDefault();
                  var $this = $(this),
                          id = $this.data('id'),
                          bid = $this.data('bid');
                  $('#Modal').foundation('reveal','open');
                  $('#Modal').load(bid);
              });
          });




      </script>
  </head>
  <body>

    <div id="header-container" class="row">
      <div id="logo" class="large-3 columns">
        <img src="/img/Iskra-Sistemi-logotip.png">
      </div>
      <div id="slick-container" class="large-9 columns hide-for-medium">
        <div id="slick" class="slick">
        </div>
      </div>
    </div>

    <div class="row">
      <div class="large-12 columns" data-magellan-expedition="fixed" id="stickyNav">
        <nav class="top-bar" data-topbar>
          <section class="top-bar-section">
           <ul class="title-area">
            <li class="toggle-topbar menu-icon"><a href="#"><span>menu</span></a></li>
          </ul>

          <ul class="left">
              @if (Auth::check() && (Auth::user()->level)>=30)
              <li class="has-dropdown administracija not-click">
                <a href="#">Administracija</a>
                  <ul class="dropdown">
                        <li><label>Vsebina</label></li>
                        <li><a href="/content/">Urejanje vsebine</a></li>
                        <li><a href="/menu/">Navigacija</a></li>
                        <li><label>Uporabniki</label></li>
                        <li><a href="/users/">Pregled uporabnikov</a></li>
                        <li><a id="modalLink" data-bid="/users/create">Nov uporabnik</a></li>
                        <li class="divider"></li>
                        <li><label>Obvestila</label></li>
                        <li><a href="/notes/">Pregled obvestil</a></li>
                        <li><a id="modalLink" data-bid="/notes/add">Novo obvestilo</a></li>
                        <li class="divider"></li>
                        <li><label>Objekti</label></li>
                        <li><a href="/buildings/index">Pregled objektov</a></li>
                        <li><a id="modalLink" data-bid="/buildings/create">Nov objekt</a></li>
                        <li class="divider"></li>
                        <li><label>Dokumenti</label></li>
                        <li><a href="/documents/index">Pregled dokumentov</a></li>
                        <li><a id="modalLink" data-bid="/documents/add">Dodajanje dokumentov</a></li>
                  </ul>
              </li>

              <?php
                /** Manager View */
              ?>
              @elseif (Auth::check() && (Auth::user()->level)>=20)
                  <li class="has-dropdown administracija not-click">
                      <a href="#">Administracija</a>
                      <ul class="dropdown">
                          <li><label>Uporabniki</label></li>
                          <li><a href="/users/">Pregled uporabnikov</a></li>
                          <li><a href="/users/create/">Nov uporabnik</a></li>
                          <li class="divider"></li>
                          <li><label>Obvestila</label></li>
                          <li><a href="/notes/">Pregled obvestil</a></li>
                          <li><a href="/notes/add/">Novo obvestilo</a></li>
                          <li class="divider"></li>
                          <li><label>Objekti</label></li>
                          <li><a href="/buildings/index">Pregled objektov</a></li>
                          <li class="divider"></li>
                          <li><label>Dokumenti</label></li>
                          <li><a href="/documents/index">Pregled dokumentov</a></li>
                          <li><a href="/documents/add">Dodajanje dokumentov</a></li>
                      </ul>
                  </li>

                <?php
                    /** Regular user View */
                ?>
                @elseif (Auth::check() && (Auth::user()->level)>=10)
                  <li class="has-dropdown administracija not-click">
                      <a href="#">Vaš račun</a>
                      <ul class="dropdown">
                          <li><label>Uporabnik</label></li>
                          <li><a href="#">Vaši podatki</a></li>
                          <li><a href="#">Sprememba gesla</a></li>
                          <li class="divider"></li>
                          <li><label>Obvestila</label></li>
                          <li><a href="/notes/">Pregled obvestil</a></li>
                          <li class="divider"></li>
                          <li><label>Objekt</label></li>
                          <li><a href="/buildings/index">Podrobnosti objekta</a></li>
                          <li class="divider"></li>
                      </ul>
                  </li>
                @endif

                @foreach ($menu as $menuItem)
                  <li><a href="/{{ $menuItem->slug }}">{{ $menuItem->name }}</a></li>
                @endforeach

              @if (!Auth::check())
              <li><a href="" data-reveal-id="login">Prijava</a></li>
              @else
              <li>{{ HTML::link('/logout', 'Odjava') }}</li>
              @endif
            </ul>
   
            <ul class="right">
              <?php
              //<li class="search">
                //<form>
                  //<input type="search">
                //</form>
              //</li>
              //<li class="has-button">
                //<a class="small button" href="#">Iskanje</a>
              //</li>
              ?>
            </ul>
          </section>
        </nav>
      </div>
    </div>

    @yield('content')

    <div id="footer-container" class="row">
      <div class="large-12 text-center columns">
        <h6>© <script>document.write(new Date().getFullYear())</script> Iskra Sistemi</h6>
      </div>
        <div class="large-3 columns right versionContainer">{{ Config::get('app.version'); }}</div>
    </div>

    @if (!Auth::check())
        <div id="login" class="reveal-modal medium" data-reveal>
            <form method="post" action="/login">
                <h2>Prijava za uporabnike</h2>
                <p class="lead">Za prijavo vpišite vašo šifro in geslo</p>
                <input type="text" placeholder="Šifra partnerja" name="partnerCode" id="partnerCode">
                <input type="password" placeholder="Geslo" name="password" id="username">
                <div style="text-align: center;"><input class="button [secondary success aler]" type="submit" value="Potrditev"></div>
                <a class="close-reveal-modal">&#215;</a>
                <p>Za prijavo uporabi: 0000/test ali 1234567890/test</p>

            </form>
        </div>
    @endif

    @if (Auth::user() && (Auth::user()->level)>=20)
        <div id="Modal" class="reveal-modal medium" data-reveal>

        </div>
    @endif

    <script>
        $(document).foundation();
    </script>
  </body>
</html>