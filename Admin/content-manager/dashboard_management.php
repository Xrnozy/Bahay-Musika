<link rel="stylesheet" href="../Admin.css">
<link rel="stylesheet" href="css/dashboard_management.css">
<link rel="stylesheet" href="content-manager/css/dashboard_management.css">
<div id="content" class="dashboard">
    <div class="company-name">
        <h1 class="company-name-title">Bahay Musika Admin Panel</h1>
    </div>
    <h3 class="dashboard-title">Dashboard</h3>
    <div class="main-container">
        <div class="first-container">
            <div class="top-container">
                <div class="news-article">
                    <h3>Total News Articles</h3>
                    <h1 class="total-news">20</h1>
                    <div class="total-recent">
                        <h5>
                            Recent update/upload:
                        </h5>
                        <h5 class="recent-count"> 5 </h5>

                    </div>
                    <div class="text-button">
                        <h5 class="text-button-news" onclick="loadContent('content-manager/news_management.php')">View all news</h5>
                    </div>

                </div>
                <div class="total-events">
                    <div class="total-event-cont">
                        <h3>Total Events</h3>
                        <h1 class="total-event">20</h1>
                        <div class="total-event-recent">
                            <h5 class="recent-event-count">5 </h5>
                            <h5>
                                more recent uploaded news
                            </h5>
                        </div>
                        <div class="text-button">

                            <h5 class="text-button-events" onclick="loadContent('content-manager/events_management.php')">View all events</h5>


                        </div>
                    </div>

                </div>
            </div>
            <div class="bottom-container">
                <div class="latest-upload">
                    <h2>Latest Event and News</h2>
                    <div class="latest-upload-cont"></div>
                </div>
            </div>
        </div>
        <div class="second-container">
            <div class="top-container">

                <div class="choir-count-cont">
                    <div class="latest-members">
                        <h3>Total Members</h3>
                        <h1 class="total-members">20</h1>
                        <div class="total-recent">
                            <h5 class="recent-members-count">5 </h5>
                            <h5>
                                more recent uploaded news
                            </h5>
                        </div>
                    </div>
                    <div class="text-button">
                        <h5 class="text-button-members" onclick="loadContent('content-manager/add_member.php')">Update Members</h5>
                    </div>
                </div>


            </div>
            <div class="bottom-container">
                <div class="members-list">

                    <h2 class="member-title">Members List</h2>
                    <div class="list">
                        <div class="member-cont">
                            <img src="https://scontent.fmnl17-5.fna.fbcdn.net/v/t39.30808-6/481259781_1223400092634847_3204620503352458800_n.jpg?_nc_cat=102&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeHZACEINnBnOrF1DLBqxRv8QLF8AAMgPLVAsXwAAyA8tdpFvBFsXdrJPvv9o0Y_Tq4HjVv6ppFipVjYxAMs4bdJ&_nc_ohc=OXuAr-zpxjgQ7kNvgFI9qKz&_nc_oc=Adnp_Fqk-kPTU9LnMosy_4WufYtviBTnq-Qe4CC_SNPMbQy7ytgH8GVNzdr05dzmWjk&_nc_zt=23&_nc_ht=scontent.fmnl17-5.fna&_nc_gid=mAVXgbpDA1KMgfV_vv5eUw&oh=00_AYFc5oupRmGWfSYedFKjvoaJzb3MivRxv6mmyY2Ngjy66Q&oe=67ED0041" alt="" class="member-img">
                            <div class="member-details">
                                <h3>Dominic G. Casinto</h3>
                                <div class="category-edit-cont">
                                    <h5>Alto</h5>

                                    <h5 class="edit-button" onclick="loadContent('content-manager/update_member.php')">Edit Member Profile</h5>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

</div>


<!--

For Content Manager:
Total News Articles 📰

Total Events Created 🎭

Upcoming Calendar Events 📅

Total Choir Members 🎤

Latest News/Events (recently added)


-->