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
    <p class="mt-0 mb-0 mr-3">ようこそ、gestさん</p>
    <!--検索フォーム-->
    <div class="col-xs-1">
      <form action="index_search.php" method="post" class="m-0">
        <div class="input-group">
          <input name="search_word" type="text" class="form-control" placeholder="Search">
          <span class="input-group-btn">
            <input type="submit" class="btn btn-dark" value="Search">
          </span>
        </div>
      </form>
    </div>
  </nav>
  <h1 class="logo">Photos Store...</h1>
</header>
