<?php
namespace Idearia\Tests;

use Idearia\Tests\Lib\WordPressTestCase;

/**
 * Test the creation and deletion of a WordPress post.
 */
class WordPressTest extends WordPressTestCase
{
	/**
	 * You can share variables between tests! This is the name
	 * of the post that will be created.
	 */
	protected static ?string $postTitle = 'Test post'; 

	/**
	 * This is the postmeta that will be attached to the created post.
	 */
	protected static ?string $postMetaKey = 'test-meta';
	protected static ?string $postMetaValue = 'Test post';

	/**
	 * Your class variables can be initiated at run-time. This variable
	 * will contain the post that will be created.
	 */
	protected static ?\WP_Post $createdPost = null; 

	/**
	 * Create a post
	 */
	public function testCreatePost(): int
	{
		$postId = wp_insert_post( [
			'post_title'    => self::$postTitle,
			'post_status'   => 'publish',
			'meta_input'    => [
				self::$postMetaKey => self::$postMetaValue
			]
		] );

		$this->assertIsInt( $postId );
		$this->assertGreaterThan( 0, $postId );

		return $postId;
	}

	/**
	 * @depends testCreatePost
	 *
	 * Fetch the created post to make sure it exists in the
	 * database.
	 * 
	 * The 'depends' line above ensures two things:
	 * 1. that this test is run after testCreatePost, and
	 * 2. that this test receives the output of testCreatePost
	 *    as a paramter.
	 */
	public function testGetPost( int $postId ): void
	{
		self::$createdPost = get_post( $postId );

		$this->assertInstanceOf( \WP_Post::Class, self::$createdPost );
		$this->assertEquals( self::$postTitle, self::$createdPost->post_title );
	}

	/**
	 * @depends testCreatePost
	 *
	 * Make sure the post meta was created succesfully
	 */
	public function testGetPostmeta( int $postId )
	{
		$postMeta = get_post_meta( $postId, self::$postMetaKey, true );
		
		$this->assertEquals( self::$postMetaValue, $postMeta );
	}

	/**
	 * @depends testGetPost
	 * @depends testGetPostmeta
	 *
	 * Delete the created post
	 */
	public function testDeletePost()
	{
		$deletedPost = wp_delete_post( self::$createdPost->ID, true );

		$this->assertInstanceOf( \WP_Post::class, $deletedPost );
	}

	/**
	 * Clean up any mess we could have made with the tests.
	 *
	 * In particular, we delete the post in the event it was created
	 * but it could not be deleted.
	 *
	 * This function is called regardless of whether the tests
	 * succeeded or failed; more details here:
	 * - https://phpunit.readthedocs.io/en/latest/fixtures.html
	 */
	public static function tearDownAfterClass(): void
	{
		parent::tearDownAfterClass();

		if ( self::$createdPost instanceof \WP_Post ) {
			wp_delete_post( self::$createdPost->ID, true );
		}
	}
}