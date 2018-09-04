<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();
        $this->call('UsersTableSeeder');
        $this->call('SettingsTableSeeder');
        $this->call('SessionsTableSeeder');
        $this->call('BannerImagesTableSeeder');
        $this->call('FaqsTableSeeder');
        $this->call('GalleriesTableSeeder');
        $this->call('DynamicMenusTableSeeder');
        $this->call('AttractionsTableSeeder');
        $this->call('EmailSettingsTableSeeder');
        $this->call('SponsorsTableSeeder');
        $this->call('TranslationsTableSeeder');
        $this->call('ProvincesTableSeeder');
        $this->call('KabkotasTableSeeder');
        $this->call('KecamatansTableSeeder');
        $this->call('KelurahansTableSeeder');
        $this->call('ContentsTableSeeder');
        $this->call('NotificationsTableSeeder');
        $this->call('EventReviewsTableSeeder');
        $this->call('StagesTableSeeder');
        $this->call('SchedulesTableSeeder');
        $this->call('PerformersTableSeeder');
        $this->call('PerformerSchedulesTableSeeder');
        $this->call('PerformerSpecificationsTableSeeder');
        $this->call('PerformerReviewsTableSeeder');
        $this->call('SurveyQuestionsTableSeeder');
        $this->call('SurveyAnswersTableSeeder');
        $this->call('ParticipantsTableSeeder');
        $this->call('ParticipantAnswersTableSeeder');
        $this->call('PerformerCandidatesTableSeeder');
        $this->call('PerformerCandidateVotesTableSeeder');
        $this->call('PerformerGroupsTableSeeder');
        $this->call('PerformerGroupVotesTableSeeder');
        $this->call('DiscussionCategoriesTableSeeder');
        $this->call('DiscussionsTableSeeder');
    }
}
