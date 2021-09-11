<?php

namespace App\Http\Controllers;

use App\Models\JobsSearch;
use Illuminate\Http\Request;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\Facades\File;

class JobsController extends Controller
{
    // search jobs post
    public function test_search(Request $request)
    {
        $hosts = ["http://127.0.0.1:9200"];

        $client = ClientBuilder::create()
            ->setHosts($hosts)
            ->build();


        // =========== create index ================
        // $params = [
        //     'index' => 'sample_index',
        //     'id' => 'sampleId',
        //     'body' => [
        //         'name' => 'sample product',
        //         'price' => '3400',
        //         'description' => 'my description'
        //     ]
        // ];
        // $response = $client->index($params);
        // dd($response);

        // =========== ดึงค่ามาแสดง ================
        // $params = [
        //     'index' => 'sample_index',
        //     'id' => 'sampleId',
        // ];
        // $response = $client->get($params);
        // dd($response);

        // =========== update index ================
        // $params = [
        //     'index' => 'sample_index',
        //     'id' => 'sampleId',
        //     'body' => [
        //         'doc' => [
        //             'price' => '50000',
        //         ]
        //     ]
        // ];
        // $response = $client->update($params);
        // dd($response);

        // ============ delete index =============
        // $params = [
        //     'index' => 'sample_index',
        //     'id' => 'sampleId',
        // ];
        // $response = $client->delete($params);
        // dd($response);

        // ============ delete index at management =============
        // $params = [
        //     'index' => 'sample_index',
        // ];
        // $response = $client->indices()->delete($params);
        // dd($response);
        // echo "deleted";

        // ============ search get,raw,first =============

        // form kibana
        // $params = [
        //     'index' => 'jobs_searches_1629038883',
        // ];
        // $response = $client->search($params);
        // dd($response);

        // form database
        // $jobs = JobsSearch::search('panuwat')->raw();
        // dd($jobs);

        // ============ get query index =============
        // $params = [
        //     'index' => 'jobs_searches_1629038883',
        //     'body' => [
        //         'query' => [
        //             'match' => [
        //                 'jobs_name' => 'web'
        //             ]
        //         ]
        //     ]

        // ];
        // $response = $client->search($params);
        // dd($response);

        // ============ get advance query index =============
        if ($query = $request->get('query')) {

            $params = [
                'index' => 'jobs_searches',
                'body' => [
                    // 'query' => [
                    //     'multi_match' => [
                    //         'query' => $query,
                    //         // 'fuzziness' => 'AUTO',
                    //         'fields' => [
                    //             'jobs_name_company',
                    //             'jobs_name',
                    //             'jobs_detail',
                    //             'jobs_address',
                    //         ]
                    //     ]
                    // ]

                    // ###################################################################
                    // ###################################################################

                    // stackoverflow
                    // For both partial and full text matching ,the following worked
                    // 'query' => [
                    //     'query_string' => [
                    //         'query' => "*" . $query . "*",
                    //         'fields' => [
                    //             'jobs_name_company',
                    //             'jobs_name',
                    //             'jobs_detail',
                    //             'jobs_address',
                    //         ]
                    //     ]
                    // ]

                    // ###################################################################
                    // ###################################################################

                    // match_phrase_prefix
                    // 'query' => [
                    //     'match_phrase_prefix' => [
                    //         'jobs_name_company' => [
                    //             'query' => $query,
                    //         ]
                    //     ]
                    // ]

                    // ###################################################################
                    // ###################################################################

                    // wildcard
                    // 'query' => [
                    //     'wildcard' => [
                    //         'jobs_name_company' => [
                    //             'value' => $query,
                    //             'boost' => 2
                    //         ]
                    //     ]
                    // ]

                    // ###################################################################
                    // ###################################################################

                    // fuzzy
                    'query' => [
                        'fuzzy' => [
                            'jobs_name_company' => [
                                'value' => $query,
                                'fuzziness' => "AUTO"
                            ]
                        ],
                        'jobs_name' => [
                            'value' => $query,
                            'fuzziness' => "AUTO"
                        ]
                    ]


                    // 'query' => [
                    //     'bool' => [
                    //         'should' => [
                    //             'query_string' => [
                    //                 'query' => "*" . $query . "*",
                    //                 'fields' => [
                    //                     'jobs_name_company',
                    //                     'jobs_name',
                    //                     'jobs_detail',
                    //                     'jobs_address',
                    //                 ],
                    //             ],
                    //             'multi_match' => [
                    //                 'query' => "*" . $query . "*",
                    //                 'fields' => [
                    //                     'jobs_name_company',
                    //                     'jobs_name',
                    //                     'jobs_detail',
                    //                     'jobs_address',
                    //                 ],
                    //                 'fuzziness' => 'AUTO',
                    //             ]
                    //         ]
                    //     ]
                    // ]

                    // 'query' => [
                    //     'multi_match' => [
                    //         'query' => "*" . $query . "*",
                    //         'fields' => [
                    //             'jobs_name_company',
                    //             'jobs_name',
                    //             'jobs_detail',
                    //             'jobs_address',
                    //         ],
                    //         'fuzziness' => 'AUTO',
                    //     ]
                    // ]



                ]
            ];



            $results = $client->search($params);

            // echo json_encode($results["hits"]["hits"]);
            // return view('applicants.applicants_search', ['query' => $query, '["hits"]["hits"]]);

            return view('applicants.applicants_search', ['query' => $query, 'results' => $results]);
        } else {
            return view('applicants.applicants_search', ['query' => null]);
        }
    }

    // ============================================================================================
    // ============================================================================================ 
    // search applicants
    public function app_search(Request $request)
    {
        $hosts = ["http://127.0.0.1:9200"];

        $client = ClientBuilder::create()
            ->setHosts($hosts)
            ->build();


        // =========== create index ================
        // $params = [
        //     'index' => 'sample_index',
        //     'id' => 'sampleId',
        //     'body' => [
        //         'name' => 'sample product',
        //         'price' => '3400',
        //         'description' => 'my description'
        //     ]
        // ];
        // $response = $client->index($params);
        // dd($response);

        // =========== ดึงค่ามาแสดง ================
        // $params = [
        //     'index' => 'sample_index',
        //     'id' => 'sampleId',
        // ];
        // $response = $client->get($params);
        // dd($response);

        // =========== update index ================
        // $params = [
        //     'index' => 'sample_index',
        //     'id' => 'sampleId',
        //     'body' => [
        //         'doc' => [
        //             'price' => '50000',
        //         ]
        //     ]
        // ];
        // $response = $client->update($params);
        // dd($response);

        // ============ delete index =============
        // $params = [
        //     'index' => 'sample_index',
        //     'id' => 'sampleId',
        // ];
        // $response = $client->delete($params);
        // dd($response);

        // ============ delete index at management =============
        // $params = [
        //     'index' => 'sample_index',
        // ];
        // $response = $client->indices()->delete($params);
        // dd($response);
        // echo "deleted";

        // ============ search get,raw,first =============

        // form kibana
        // $params = [
        //     'index' => 'jobs_searches_1629038883',
        // ];
        // $response = $client->search($params);
        // dd($response);

        // form database
        // $jobs = JobsSearch::search('panuwat')->raw();
        // dd($jobs);

        // ============ get query index =============
        // $params = [
        //     'index' => 'jobs_searches_1629038883',
        //     'body' => [
        //         'query' => [
        //             'match' => [
        //                 'jobs_name' => 'web'
        //             ]
        //         ]
        //     ]

        // ];
        // $response = $client->search($params);
        // dd($response);

        // ============ get advance query index =============
        if ($query = $request->get('query')) {

            $params = [
                'index' => 'histories',
                'body' => [
                    'query' => [
                        'multi_match' => [
                            'query' => $query,
                            "fields" => [
                                "name_prefix",
                                "first_name",
                                "last_name",
                                "university",
                                "faculty",
                                "branch",
                                "educational",
                                "experience",
                                "dominant_language",
                                "language_learned",
                                "charisma",
                                "district",
                                "canton",
                                "province",
                                "my_district",
                                "my_canton",
                                "my_province",
                            ]
                        ]
                    ]
                ]
            ];

            $results = $client->search($params);

            // echo json_encode($results["hits"]["hits"]);
            // return view('applicants.applicants_search', ['query' => $query, '["hits"]["hits"]]);

            return view('ent.ent_index', ['query' => $query, 'results' => $results]);
        } else {
            return view('ent.ent_index', ['query' => null]);
        }
    }

    // // ============================================================================================
    // // ============================================================================================ 

    // // ==================== text search ===================
    // // public function search(Request $request)
    // // {
    // //     if ($query = $request->get('query')) {
    // //         $results = JobsSearch::search($query)->get();

    // //         return view('applicants.applicants_search', ['query' => $query, 'results' => $results]);
    // //     } else {
    // //         return view('applicants.applicants_search', ['query' => null]);
    // //     }
    // // }
}
