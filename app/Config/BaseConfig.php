<?php

namespace App\Config;

use App\SuitEvent\Models\Email;
use App\SuitEvent\Models\Gallery;
use App\SuitEvent\Models\Participant;
use App\SuitEvent\Models\Performer;
use App\SuitEvent\Models\PerformerCandidate;
use App\SuitEvent\Models\PerformerSpecification;
use App\SuitEvent\Models\Schedule;
use App\SuitEvent\Models\Sponsor;
use App\SuitEvent\Models\SurveyQuestion;

class BaseConfig
{
    public static function getData()
    {
        return [
            "pageId" => [
                'A' => [
                    'label' => 'Home',
                    'route' => 'backend.home.index',
                    'icon' => 'fa-home',
                    'roles' => ['admin'],
                    'submenu' => [
                        'A1' => [
                            'label' => 'Overview',
                            'route' => 'backend.home.index',
                            'icon' => 'fa fa-dashboard',
                            'roles' => ['admin'],
                        ],
                        /*'A2' => [
                            'label' => 'Notification',
                            'route' => 'backend.notification.index',
                            'icon' => 'fa fa-bell',
                            'roles' => ['admin'],
                        ],*/
                        'A3' => [
                            'label' => 'My Account',
                            'route' => 'backend.useraccount.index',
                            'icon' => 'icon-user',
                            'roles' => ['admin'],
                        ],
                    ]
                ],
                'B' => [
                    'label' => 'General',
                    'route' => '',
                    'icon' => 'fa-globe',
                    'roles' => ['admin'],
                    'submenu' => [
                        'B0' => [
                           'label' => 'Menu',
                           'route' => 'backend.menus.index',
                           'icon' => 'fa fa-map-signs',
                           'roles' => ['admin'],
                        ],
                        /*'B1' => [
                            'label' => 'Content Type & Category',
                            'route' => 'backend.contenttype.index',
                            'icon' => 'fa fa-file-code-o',
                            'roles' => ['admin'],
                        ],*/
                        'B4' => [
                            'label' => 'Banner Image',
                            'route' => 'backend.bannerimages.index',
                            'icon' => 'fa fa-picture-o',
                            'roles' => ['admin'],
                        ],
                        /*'B9' => [
                            'label' => 'Unique Selling Point',
                            'route' => 'backend.uniquesellingpoint.index',
                            'icon' => 'fa fa-lightbulb-o',
                            'roles' => ['admin'],
                        ],*/
                        'B3' => [
                            'label' => 'FAQ',
                            'route' => 'backend.faq.index',
                            'icon' => 'fa fa-question-circle',
                            'roles' => ['admin'],
                        ],
                        /*'B5' => [
                            'label' => 'Ads',
                            'route' => 'backend.advertisements.index',
                            'icon' => 'fa fa-bullhorn',
                            'roles' => ['admin'],
                        ],*/
                        /*'B6' => [
                            'label' => 'Contact Form',
                            'route' => 'backend.contactmessage.index',
                            'icon' => 'fa fa-envelope-o',
                            'roles' => ['admin'],
                        ],*/
                        /*'B2' => [
                            'label' => 'Content',
                            'route' => 'backend.content.index',
                            'icon' => 'fa fa-file-code-o',
                            'roles' => ['admin'],
                        ],*/
                        'B7' => [
                            'label' => 'General Setting',
                            'route' => 'backend.settings.view',
                            'icon' => 'fa fa-cogs',
                            'roles' => ['admin'],
                        ],
                        /*'B8' => [
                            'label' => 'Email Setting',
                            'route' => 'backend.emailsettings.index',
                            'icon' => 'fa fa-envelope',
                            'roles' => ['admin'],
                        ],*/
                    ]
                ],
                'C' => [
                    'label' => 'User',
                    'route' => '',
                    'icon' => 'fa-user',
                    'roles' => ['admin'],
                    'submenu' => [
                        'C1' => [
                            'label' => 'User Management',
                            'route' => 'backend.user.index',
                            'icon' => 'fa fa-users',
                            'roles' => ['admin'],
                        ]
                    ]
                ],
                'D' => [
                    'label' => 'Performer',
                    'route' => '',
                    'icon' => 'fa-male',
                    'roles' => ['admin'],
                    'submenu' => [
                        /*'D2' => [
                            'label' => 'Performer Candidate',
                            'route' => 'backend.performer-candidate.index',
                            'icon' => 'fa fa-male',
                            'roles' => ['admin'],
                        ],
                        'D3' => [
                            'label' => 'Collaboration Summary',
                            'route' => 'backend.performer-group.index',
                            'icon' => 'fa fa-users',
                            'roles' => ['admin'],
                        ],*/
                        'D1' => [
                            'label' => 'Performer (Line Up)',
                            'route' => 'backend.performer.index',
                            'icon' => 'fa fa-male',
                            'roles' => ['admin'],
                        ]
                    ]
                ],
                'E' => [
                    'label' => 'Schedule',
                    'route' => '',
                    'icon' => 'fa-calendar',
                    'roles' => ['admin'],
                    'submenu' => [
                        'E2' => [
                            'label' => 'Stage/ Area',
                            'route' => 'backend.stage.index',
                            'icon' => 'fa fa-hospital-o',
                            'roles' => ['admin'],
                        ],
                        'E1' => [
                            'label' => 'Schedule/ Session',
                            'route' => 'backend.schedule.index',
                            'icon' => 'fa fa-sort-numeric-asc',
                            'roles' => ['admin'],
                        ]
                    ]
                ],
                'G' => [
                    'label' => 'Miscellaneous',
                    'route' => '',
                    'icon' => 'fa-puzzle-piece',
                    'roles' => ['admin'],
                    'submenu' => [
                        'G1' => [
                            'label' => 'Gallery',
                            'route' => 'backend.gallery.index',
                            'icon' => 'fa fa-picture-o',
                            'roles' => ['admin'],
                        ],
                        /*'G2' => [
                            'label' => 'Location',
                            'route' => 'backend.attraction.index',
                            'icon' => 'fa fa-eye',
                            'roles' => ['admin'],
                        ]*/
                    ]
                ],
                'F' => [
                    'label' => 'Partnership',
                    'route' => '',
                    'icon' => 'fa-thumbs-up',
                    'roles' => ['admin'],
                    'submenu' => [
                        'F1' => [
                            'label' => 'Sponsor',
                            'route' => 'backend.sponsor.index',
                            'icon' => 'fa fa-handshake-o',
                            'roles' => ['admin'],
                        ]
                    ]
                ],
                // 'H' => [
                //     'label' => 'Interaction',
                //     'route' => '',
                //     'icon' => 'fa-bullhorn',
                //     'roles' => ['admin'],
                //     'submenu' => [
                //         'H1' => [
                //             'label' => 'Volunteer',
                //             'route' => 'backend.participant.index',
                //             'icon' => 'fa fa-hand-peace-o',
                //             'roles' => ['admin'],
                //         ],
                //         'H2' => [
                //             'label' => 'Volunteer Question',
                //             'route' => 'backend.surveyquestion.index',
                //             'icon' => 'fa fa-question-circle-o',
                //             'roles' => ['admin'],
                //         ],
                //         'H3' => [
                //             'label' => 'Survey Answer',
                //             'route' => 'backend.surveyanswer.index',
                //             'icon' => 'fa fa-question-circle-o',
                //             'roles' => ['admin'],
                //         ],
                //         'H4' => [
                //             'label' => 'Event Review',
                //             'route' => 'backend.eventreview.index',
                //             'icon' => 'fa fa-star',
                //             'roles' => ['admin'],
                //         ]
                //     ]
                // ],
                // 'I' => [
                //     'label' => 'Master Data',
                //     'route' => '',
                //     'icon' => 'fa-book',
                //     'roles' => ['admin'],
                //     'submenu' => [
                //         'I3' => [
                //             'label' => 'Provinces',
                //             'route' => 'backend.province.index',
                //             'icon' => 'fa fa-map-o',
                //             'roles' => ['admin'],
                //         ],
                //         'I4' => [
                //             'label' => 'Cities',
                //             'route' => 'backend.city.index',
                //             'icon' => 'fa fa-map-o',
                //             'roles' => ['admin'],
                //         ],
                //         'I5' => [
                //             'label' => 'Kecamatan',
                //             'route' => 'backend.kecamatan.index',
                //             'icon' => 'fa fa-map-o',
                //             'roles' => ['admin'],
                //         ],
                //         'I6' => [
                //             'label' => 'Kelurahan',
                //             'route' => 'backend.kelurahan.index',
                //             'icon' => 'fa fa-map-o',
                //             'roles' => ['admin'],
                //         ]
                //     ]
                // ],
                'J' => [
                    'label' => 'Discussion',
                    'route' => '',
                    'icon' => 'fas fa-comments',
                    'roles' => ['admin'],
                    'submenu' => [
                        'J1' => [
                            'label' => 'Discussion Category',
                            'route' => 'backend.discussioncategories.index',
                            'icon' => 'fa fa-tag',
                            'roles' => ['admin'],
                        ],
                        'J2' => [
                            'label' => 'Discussion',
                            'route' => 'backend.discussions.index',
                            'icon' => 'fa fa-comment',
                            'roles' => ['admin'],
                        ],
                    ]
                ],
            ],

            "performer_specification_key" => [
                PerformerSpecification::KEY_SOCIAL_FACEBOOK => 'Facebook',
                PerformerSpecification::KEY_SOCIAL_TWITTER => 'Twitter',
                PerformerSpecification::KEY_SOCIAL_INSTAGRAM => 'Instagram',
                PerformerSpecification::KEY_SOCIAL_YOUTUBE => 'Youtube',
                'soundcloud' => 'Soundcloud',
                'spotify' => 'Spotify',
                'website' => 'Website',
            ],
            "performer_candidate_type" => [
                PerformerCandidate::TYPE_SOLO => "Solo",
                PerformerCandidate::TYPE_GROUP => "Band",
                'collab' => "Collaboration"
            ],
            "participant_type" => [
                Participant::TYPE_VOLUNTEER => "Volunteer"
            ],
            "survey_question_type" => [
                SurveyQuestion::TYPE_VOLUNTEER => "Volunteer"
            ],
            "gallery_type" => [
                Gallery::TYPE_IMAGE => "Image",
                Gallery::TYPE_VIDEO => "Video"
            ],
            "sponsor_type" => [
                Sponsor::TYPE_ORGANIZER => "Organizer (Powered By)",
                Sponsor::TYPE_SUPPORTER => "Supporter (Sponsored By)",
                Sponsor::TYPE_OFFICIAL_TICKETING => "Official Ticketing Partner",
                Sponsor::TYPE_MEDIA => "Media Partner",
            ],

            "article" => [
                "draft" => "Draft",
                "published" => "Published"
            ],

            "article_category" => [
                "promo" => "Promotion",
                "blog" => "News",
                "static" => "Static",
                "career" => "Career",
                "terms" => "Terms",
                "buyerinfo" => "Buyer Info",
                "sellerinfo" => "Seller Info"
            ],

            "banner" => [
                "active" => "Active",
                "timed" => "Timed",
                "inactive" => "Non Active",
            ],

            "contactmessage" => [
                "not_responded" => "Not Responded",
                "reply_sent" => "Responded - Reply Sent",
                "ignored" => "Responded - Ignored"
            ],

            "menu_position" => [
                "web-header" => "Web (Header)",
                "mobile" => "Mobile App"
            ],
            "banner_position" => [
                "main-banner" => 'Main Banner',
                "side-banner" => 'Side Banner',
                "ticket" => 'Ticket Banner',
                "merch" => 'Merchandise Banner'
            ],
            "performer_type" => [
                "international" => 'International Artist',
                "national" => 'National Artist'
            ],
            "thumbnail_dimension" => [
                "bannerimage" => [
                    'medium_cover' => '480x_',
                    'default_cover' => '820x660',
                    'merch' => '400x400'
                ],
                "category" => [
                    'medium_cover' => '480x_',
                    "homepage" => "320x255"
                ],
                "content" => [
                    'medium_cover' => '480x_',
                    "thumbnail_list" => "278x186",
                    "large_cover" => "1108x335",
                ],
                "contentattachment" => [
                    'medium_cover' => '480x_',
                    "detail" => "_x330"
                ],
                "performer" => [
                    'xsmall_square' => '90x90',
                    'small_square' => '128x128',
                    'medium_square' => '256x256',
                    'large_square' => '512x512',
                    'xlarge_square' => '2048x2048',
                    'small_cover' => '240x_',
                    'normal_cover' => '360x_',
                    'medium_cover' => '480x_',
                    'medium_plus_cover' => '600x_',
                    'large_cover' => '1280x_',
                    'small_banner' => '_x240',
                    'normal_banner' => '_x360',
                    'medium_banner' => '_x480',
                    'large_banner' => '_x1280',
                    'medium_avatar' => '540x_'
                ],
                "schedule" => [
                    'xsmall_square' => '90x90',
                    'small_square' => '128x128',
                    'medium_square' => '256x256',
                    'large_square' => '512x512',
                    'xlarge_square' => '2048x2048',
                    'small_cover' => '240x_',
                    'normal_cover' => '360x_',
                    'medium_cover' => '480x_',
                    'large_cover' => '1280x_',
                    'small_banner' => '_x240',
                    'normal_banner' => '_x360',
                    'medium_banner' => '_x480',
                    'large_banner' => '_x1280',
                    'small_pre_event' => '_x55'
                ],
                "gallery" => [
                    'medium_cover' => '480x_',
                    'small_image' => '180x180',
                    'medium_image' => '800x_',
                    'small_video' => '320x180'
                ],
                "sponsor" => [
                    'small_square' => '128x128',
                    'medium_square' => '256x256',
                    'large_square' => '512x512',
                    'xlarge_square' => '2048x2048',
                    'xsmall_cover' => '200x_',
                    'small_cover' => '240x_',
                    'normal_cover' => '360x_',
                    'medium_cover' => '480x_',
                    'large_cover' => '1280x_',
                    'small_banner' => '_x240',
                    'normal_banner' => '_x360',
                    'medium_banner' => '_x480',
                    'large_banner' => '_x1280'
                ]
            ],
            'rules' => [
                'user' => [
                    'password' => 'required',
                    'name' => 'required',
                    'role' => 'required',
                    'birthdate' => 'required|date|before:17 years ago',
                    'email' => 'required|email|unique:users,email'
                ],
                'contactmessage' => [
                    'sender_name' => 'required|string',
                    'sender_email' => 'required|email',
                    'content' => 'required|string',
                    'category_id' => 'required|exists:email_categories,id',
                    'status' => 'required|string'
                ],
                'category' => [
                    'name' => 'required',
                    'code' => 'nullable'
                ],
                'bannerimage' => [
                    'active_start_date' => 'date|required_if:status,timed',
                    'active_end_date' => 'date|required_if:status,timed',
                    'text' => 'nullable'
                ]
            ],
            'routes' => [
                "password_reset" => url('secret/reset_password/{token}'),
            ],
        ];
    }
}
