<template>
  <div class="authorbox">
    <div class="profile">
      <img src="https://www.placecage.com/c/400/400" />
      <div class="social">
        <a href="#" target="_blank">FB</a>|
        <a href="#" target="_blank">IN</a>|
        <a href="#" target="_blank">TW</a>| 
        <a href="#" target="_blank">WEBSITE</a>
      </div>
    </div>

    <div class="description">
      <div class="name">
        Dr. Stanley Goodspeed
      </div>
      <div class="content">
       It's a Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
      </div>
    </div>
  </div>
</template>




<style lang="scss" scoped>
.social {
  text-align: center;
  display: flex;
  justify-content: space-between;
  width: 75%;
}

.authorbox {
  display: flex;
  justify-content: center;
  align-items: center;

  .profile {
    flex: 0 1 25%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }

  .description {
    text-align: left;
    flex: 0 1 75%;
  }
}

.profile {
  img {
    width: 300px; 
    border-radius: 50%;
  }
}

.description {
  margin-left: 2rem;

  .name {
    font-size: 2.5rem;
  }
  .content {
    line-height: 1.1;
  }
}
</style>