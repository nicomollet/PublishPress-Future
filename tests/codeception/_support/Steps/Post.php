<?php

namespace Steps;

trait Post
{
    /**
     * @Given post :postSlug exists
     */
    public function postExists($postSlug)
    {
        $this->factory('Creating new post')->post->create(
            [
                'post_name' => $postSlug,
            ]
        );
    }

    /**
     * @Given I am editing post :postSlug
     */
    public function iAmEditingPost($postSlug)
    {
        $args = [
            'name'        => $postSlug,
            'post_type'   => 'post',
            'post_status' => 'publish',
            'numberposts' => 1
        ];

        $postId = null;
        $posts  = get_posts($args);
        if (! empty($posts)) {
            $postId = $posts[0]->ID;
        }

        if (! empty($postId)) {
            $this->amOnAdminPage("post.php?post=$postId&action=edit");
        }
    }

    /**
     * @Then I see the component panel :text
     */
    public function iSeeComponentPanel($text)
    {
        $this->see($text, '.components-panel .post-expirator-panel');
    }

    /**
     * @Then I see :text
     */
    public function iSee($text)
    {
        $this->see($text);
    }

    /**
     * @Then I see :text in code
     */
    public function iSeeInCode($text)
    {
        $this->iSeeInCode($text);
    }
}
