<ul class="nav nav-tabs nav-fill profile-nav-tab">
<li class="nav-item">
  <a class="nav-link {{ (request()->is('user/post-edit')) ? 'active' : '' }}" href="{{route('post.edit',['id'=>$adsDetails->id])}}">
    <em class="mr-lg-2 mr-1 fa fa-edit"></em>Edit Ad</a>
</li> 

<li class="nav-item">
  <a class="nav-link {{ (request()->is('user/post-description-edit')) ? 'active' : '' }}" href="{{route('description.edit',['id'=>$adsDetails->id])}}">
    <em class="mr-lg-2 mr-1 fa fa-edit"></em>Edit Ad Description</a>
</li> 

<li class="nav-item">
  <a class="nav-link {{ (request()->is('user/post-images-edit')) ? 'active' : '' }}" href="{{route('images.edit',['id'=>$adsDetails->id])}}">
    <em class="mr-lg-2 mr-1 fa fa-edit"></em>Edit Ad Images</a>
</li>

</ul>