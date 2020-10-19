<!-- 未ログインheader -->
<header>
  <nav class="navbar navbar-expand-sm navbar-light bg-light fixed-top">
    <a class="navbar-brand" href="<?php print(HOME_URL);?>"><button type="button" class="btn btn-dark  " data_but="btn-xs"><i class='fa '></i> Market</button></a>
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#headerNav" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="ナビゲーションの切替">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="headerNav">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?php print(RANKING_URL);?>"><button type="button" class="btn btn-light  " data_but="btn-xs"><i class='fa '></i> Ranking</button></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php print(SIGNUP_URL);?>"><button type="button" class="btn btn-light  " data_but="btn-xs"><i class='fa '></i> Sign-up</button></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php print(LOGIN_URL);?>"><button type="button" class="btn btn-light  " data_but="btn-xs"><i class='fa '></i> Sign-in</button></a>
        </li>
      </ul>
    </div>
  </nav>
  <h1 class="logo">Photos Store...</h1>
</header>
