<section id="team" class="team">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title mx-auto text-center">
                    <span>Our Team</span>
                    <h2>Meet The Team</h2>
                    <p>
                        There are many variations of passages of Lorem Ipsum available
                        but the majority have suffered alteration in some form.
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach ($teams as $team)
                <div class="col-xl-3 col-lg-3 col-sm-6">
                    <div class="single-team wow fadeInUp" data-wow-delay=".1s">
                        <div class="team-image-wrapper">
                            <div class="team-image">
                                <img src="front-template/assets/images/team/team-01.png" alt="team" />
                            </div>
                        </div>
                        <div class="team-info">
                            <h5>{{$team->team_name}}</h5>
                            <h6>{{$team->team_function}}</h6>
                        </div>
                        <ul class="team-socials">
                            <li>
                                <a href="{{$team->team_facebook_profile}}" target="_blank">
                                    <i class="lni lni-facebook-filled"></i>
                                </a>
                            </li>
                            <li>
                                <a href="{{$team->team_twitter_profile}}" target="_blank">
                                    <i class="lni lni-twitter-filled"></i>
                                </a>
                            </li>
                            <li>
                                <a href="{{$team->team_linkedin_profile}}" target="_blank">
                                    <i class="fa fa-linkedin-square"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>
