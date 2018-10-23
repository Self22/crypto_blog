<?php

namespace App;

use App\Helpers\Spintax\Spintax;
use DB;
use App\ParseLink;
use Carbon\Carbon;
use App\Category;
use App\Tag;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class UniqText extends Model
{
    use Sluggable;

    protected $fillable = ['anchor', 'category', 'tag', 'time', 'date', 'news_text', 'slug', 'description'];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'uniq_text_tag', 'uniq_text_id', 'tag_id');
    }

    public static function getCategoriesCount(){
        return Category::all()->count();
    }

    public static function getTagsCount(){
        return Tag::all()->count();
    }

    public static function getDateAttribute()
    {
        setlocale(LC_ALL, 'en' . '.utf-8', 'en_EN' . '.utf-8', 'en', 'en_EN');
        return (Carbon::now('Europe/Kiev')->formatLocalized("%d %B, %Y"));
    }

    public static function getTimeAttribute()
    {
        setlocale(LC_ALL, 'en' . '.utf-8', 'en_EN' . '.utf-8', 'en', 'en_EN');
        return (Carbon::now('Europe/Kiev')->format('H:i'));
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'anchor'
            ]
        ];
    }

    private static function wordai_api($text, $quality, $email = 'evaturned@gmail.com', $pass = '24562456zh')

    {

        if (isset($text) && isset($quality) && isset($email) && isset($pass)) {

            $text = urlencode($text);

            $ch = curl_init('http://wordai.com/users/turing-api.php');

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            curl_setopt($ch, CURLOPT_POST, 1);

            curl_setopt($ch, CURLOPT_POSTFIELDS, "s=$text&quality=$quality&email=$email&pass=$pass&output=json");

            $result = curl_exec($ch);

            curl_close($ch);

            return $result;

        } else {

            return 'Error: Not All Variables Set!';

        }

    }


    public static function create_uniq_news()
    {
        ini_set('max_execution_time', 9000);
        $example = ParseLink::where('uniqued', 0)->firstOrFail();
        $img = $example->img_preview;
        $originalLink = $example->id;

        $uniqText = UniqText::wordai_api($example->news_text, 'Very Unique');
        $allText = json_decode($uniqText, true);
        $uniqTextArray = explode('Kcoin', $allText["text"]);
//        print_r($uniqTextArray);
        $anchor =  $uniqTextArray[0];
        $description =  $uniqTextArray[1];
        $text =  $uniqTextArray[2];
//
//        echo $anchor.'<br>'.$description.'<br>'.$text;
        // обрабатываем спинтакс
        $spin = new Spintax;
        $anchor = strip_tags($spin->process($anchor));
        $text = $spin->process($text);
        $description = $spin->process($description);

//         // сохраняем статью
        UniqText::save_uniq_text($anchor, $text, $description, $img, $originalLink);

        $example->uniqued = 1;
        $example->save();
    }

    private static function save_uniq_text($anchor, $news_text, $description, $img, $originalLink){
        if (UniqText::where('anchor', $anchor)->exists()) {
            return;
        }

        $article = new UniqText;
        $article->anchor = trim(html_entity_decode($anchor));
        $article->category_id = rand(1, self::getCategoriesCount());
        $article->tag = rand(1, self::getTagsCount());
        $raw = str_replace('"', '', $news_text);
        $raw = str_replace('--', '-', $raw);
        $article->news_text = $news_text;
        $article->img_preview =  $img;
        $article->description = strip_tags($description);
        $article->date = UniqText::getDateAttribute();
        $article->time = UniqText::getTimeAttribute();
        $article->original_link = $originalLink;
        $article->save();


        // присваиваем случайный тэги
        $allTags = Tag::all()->pluck('id');
        $tagNum = rand(1, $allTags->count());
        $articleTags = [];
        for($a=0; $a<$tagNum; $a++){
            $articleTags[]=$allTags->random();
        }
        $article->tags()->sync($articleTags, false);
    }

    public static function clean_uniq_text(){
        $texts = UniqText::all(['id', 'news_text']);
        foreach ($texts as $text){
            $raw = $text->news_text;
            $raw = str_replace('"', '', $raw);
            $raw = str_replace('--', '-', $raw);
            $raw = str_replace('<p></p>', '', $raw);
            $raw = str_replace('{', '', $raw);
            $raw = str_replace('}', '', $raw);
            $raw = preg_replace('/<input(?:\\s[^<>]*)?>/i', '', $raw);
            $raw = preg_replace("'Sign up for Blockchain Bites and CoinDesk Weekly, sent Sunday-Friday. By Registering, you agree to the terms and conditions and privacy policy'", '', $raw);
            $newText = UniqText::find($text->id);
            $newText->news_text = $raw;
            $newText->save();

        }
    }

    public static function addTagsAndCategoriesToArticles(){

        $countCategories = Category::all()->pluck('id');
        $allTags = Tag::all()->pluck('id');

        $posts = UniqText::all();
        foreach ($posts as $post){
            $post->category_id = $countCategories->random();
            $post->save();
            $tagNum = rand(1, $allTags->count());
            $articleTags = [];
            for($a=0; $a<$tagNum; $a++){
                $articleTags[]=$allTags->random();
            }
            $post->tags()->sync($articleTags, false);

        }


    }

    public static function test_wordai(){
        function api($text, $quality, $email = 'evaturned@gmail.com', $pass = '24562456zh')

        {

            if(isset($text) && isset($quality) && isset($email) && isset($pass))

            {

                $text = urlencode($text);

                $ch = curl_init('http://wordai.com/users/turing-api.php');

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                curl_setopt ($ch, CURLOPT_POST, 1);

                curl_setopt ($ch, CURLOPT_POSTFIELDS, "s=$text&quality=$quality&email=$email&pass=$pass&output=json");

                $result = curl_exec($ch);

                curl_close ($ch);

                return $result;

            }

            else

            {

                return 'Error: Not All Variables Set!';

            }

        }

//The variable quality can currently be 'Regular', 'Unique', 'Very Unique', 'Readable', or 'Very Readable'

        echo api(stripslashes('<p>"Shock" describes the mood ever since one of bitcoin\'s most severe bugs was discovered and patched last week.</p><p>As the community reels over the vulnerability that was hiding in the code for two years, and that could have been exploited to print more bitcoins than the 21 million intended to be produced, developers are wondering: Is there a way to prevent such a severe bug from being added to the code again?</p><p>Days after the discover, there hasn\'t been any formal proposals. But that\'s not to say the event hasn\'t prompted discussion about how bitcoin works and how similar bugs in the cryptocurrency\'s most popular software implementation, Bitcoin Core, can be identified and resolved in the future.</p><p>It\'s an important question, too – What if a malicious actor had found the exploit first? What if there are other hidden bugs in the code right now? What other disastrous outcomes could occur? <div id="top-id"></div> </p><p>To this point, pseudonymous bitcoin subreddit moderator \'Theymos\' urged the community not to forget the bug.</p><p>He argued it was "was undeniably a major failure" in a widely-circulated post, adding:</p><p>"If all of Bitcoin Core\'s policies and practices are kept the same, then it\'s inevitable that a similar failure will eventually happen again, and we might not be so lucky with how it turns out that time."</p><p>That said, there\'s an argument to be made that Bitcoin Core, powered by an open network of global participants, now has a more robust process for code review than at any time in the technology\'s history.</p><img src="../img/theme_imgs/deepcoin.png" alt="     In Wake of \'Major Failure,\' Bitcoin Code Review Comes Under Scrutiny  Sep 25, 2018 by Alyssa Hertig   " class="theme__image"><p>Right now, the implementation has more developers than ever contributing to the open-source codebase. And it is tested quite a bit; by one estimate, tests make up nearly 20 percent of the codebase.</p><p>Still, developers argue more could be done to make sure the digital money works smoothly.</p><p>Theymos thinks one avenue would be to build "more sophisticated" tests tailored at locating severe, but hard to find bugs, like the one last week. "Perhaps all large bitcoin companies should be expected by the community to assign skilled testing specialists to Core," he continued, adding:</p><p>"Currently a lot of companies don\'t contribute anything to Core development."</p><p>Bitcoin Core contributor James Hilliard stressed much the same, suggesting that developers can increase the "amount" and "quality" of testing. Though, this might be easier said than done. Bitcoin Core contributor Greg Maxwell agreed in Theymos\'s thread that testing is important, but the quality and detail of the tests is important.</p><p>"Directing more effort into testing has been a long-term challenge for us, in part because the art and science of testing is no less difficult than any other aspect of the system\'s engineering. Testing involves particular skills and aptitudes that not everyone has," Maxwell said.</p><p>This sort of expertise is hard to find.</p><p>"Bitcoin development is largely bottlenecked by code review and there are not a large amount of people out there who are able to do that," Hilliard told CoinDesk.</p><p>Yet, many others believe the responsibility shouldn\'t only rest on developers. A common sentiment shared was that as a decentralized project with no leaders, keeping bitcoin free of errors is a shared responsibility.</p><p>"My main problem with a lot of the backlash is people pointing at specific developers to assign blame. The entire project is open, there is no \'membership\' and users have just as much of a responsibility to audit code as developers actively contributing," pseudonymous bitcoin enthusiast Shinobimonkey told CoinDesk.</p><p>Such a sentiment was shared by Bitcoin Core maintainer Wladimir van der Laan who tweeted, "It was wrong that the buggy code was merged. Yes, we screwed up but the \'we\' that screwed up is very wide. The whole community screwed up by not reviewing consensus changes thoroughly enough."</p><p>Chaincode engineer John Newberry agreed. Even though he didn\'t write the buggy code, he argued that as a developer in the bitcoin world, he played a role in the error, too, by not looking closely enough.</p><p>He went as far as to say that the code in question had looked funny to him. Yet, he assumed others had already checked.</p><p>"Instead of verifying for myself, I trusted that people smarter and wiser than I am had it covered. I took it for granted that someone else had done the work," he stated.</p><p>Still, some argue there will always be a risk of bugs.</p><p>"There\'ve been bugs in bitcoin before and there\'ll be bugs again. It\'s just software. There\'s nothing magical to it," tweeted Blockstream COO Samson Mow.</p><p>Along these lines, there\'s another popular idea floating around.</p><p>Today in bitcoin, there\'s one main bitcoin software, Bitcoin Core, run by 95 percent of bitcoin nodes. (At least that\'s according to one count – interestingly, there\'s no way to see every bitcoin node, because some nodes want more privacy and don\'t advertise their existence to the rest of the network.)</p><p>One idea, then, is to make more bitcoin code implementations. That way if one implementation has a disastrous bug that crashes the network, the other implementations could still be fine, keeping bitcoin as a whole running.</p><p>And to a certain degree, this already exists. There are lesser-known code implementations, such as Bitcoin Knots and Btcd. Elsewhere in the cryptocurrency world, this is becoming the norm. For instance, ethereum has two dominant implementations, geth and parity, each of which can be used by anyone running the software.</p><p>Still, many bitcoin developers worry that adding more than one implementation could introduce problems that would be even worse than last week\'s vulnerability.</p><p>"What many people do not realize is that having people run different implementations makes it easier for attackers to partition the network," Bitcoin Core contributor Andrew Chow argued in a conversation outlining the pros and cons.</p><p>As such, developers don\'t necessarily agree on exactly what needs to be done.</p><p>Theymos perhaps put it best when he said:</p><p>"I don\'t know exactly how this can be prevented from happening again, but I do know that it would be a mistake for the community to brush off this bug just because it ended up being mostly harmless this time."</p><p><i>Metal shield image via Shutterstock</i></p><p> <br /> </p><p>SecurityBitcoin CoreBitcoinBug</p><p>Sign up for Blockchain Bites and CoinDesk Weekly, sent Sunday-Friday. By signing up, you agree to our terms & conditions and privacy policy</p>'),'Very Unique');

    }




}
