<?php

use PHPUnit\Framework\TestCase;

/**
 * Class CharacterParserTest
 */
class CharacterParserTest extends TestCase
{
    /**
     * @var \Jikan\Parser\Character
     */
    private $parser;

    public function setUp()
    {
        $request = new \Jikan\Request\Character(116281);
        $client = new \Goutte\Client();
        $crawler = $client->request('GET', $request->getPath());
        $this->parser = new \Jikan\Parser\Character($crawler);
    }

    /**
     * @test
     * @vcr CharacterParserTest.yaml
     */
    public function it_gets_the_mal_id()
    {
        self::assertEquals(116281, $this->parser->getMalId());
    }

    /**
     * @test
     * @vcr CharacterParserTest.yaml
     */
    public function it_gets_the_character_url()
    {
        self::assertEquals('https://myanimelist.net/character/116281/Momonga', $this->parser->getCharacterUrl());
    }

    /**
     * @test
     * @vcr CharacterParserTest.yaml
     */
    public function it_gets_the_name()
    {
        self::assertEquals('Momonga', $this->parser->getName());
    }

    /**
     * @test
     * @vcr CharacterParserTest.yaml
     */
    public function it_gets_the_name_in_kanji()
    {
        self::assertEquals('Momonga  (モモンガ)', $this->parser->getNameKanji());
    }

    /**
     * @test
     * @vcr CharacterParserTest.yaml
     */
    public function it_gets_the_nicknames()
    {
        $aliases = $this->parser->getNameNicknames();
        self::assertCount(2, $aliases);
        self::assertContains('Momon', $aliases);
        self::assertContains('Ainz Ooal Gown', $aliases);
    }

    /**
     * @test
     * @vcr CharacterParserTest.yaml
     */
    public function it_gets_the_about()
    {
        self::assertContains('He is the guild master of Ainz Ooal Gown and regarded', $this->parser->getAbout());
        self::assertContains('(Source: Overlord Wikia)', $this->parser->getAbout());
    }

    /**
     * @test
     * @vcr CharacterParserTest.yaml
     */
    public function it_gets_the_member_favorites()
    {
        self::assertEquals(3750, $this->parser->getMemberFavorites());
    }

    /**
     * @test
     * @vcr CharacterParserTest.yaml
     */
    public function it_gets_the_image()
    {
        self::assertEquals(
            'https://myanimelist.cdn-dena.com/images/characters/3/288006.jpg',
            $this->parser->getImage()
        );
    }

    /**
     * @test
     * @vcr CharacterParserTest.yaml
     */
    public function it_gets_the_animeography()
    {
        $animeography = $this->parser->getAnimeography();
        self::assertCount(9, $animeography);
        self::assertContainsOnly(\Jikan\Model\Animeography::class, $animeography);
    }

    /**
     * @test
     * @vcr CharacterParserTest.yaml
     */
    public function it_gets_the_mangaography()
    {
        $manaography = $this->parser->getMangaography();
        self::assertCount(2, $manaography);
        self::assertContainsOnly(\Jikan\Model\Mangaography::class, $manaography);
    }
}
