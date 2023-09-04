<?php
$string['actions'] = 'Actions';
$string['add_bot'] = 'Create new bot';
$string['add_content'] = 'Add content';
$string['add_model'] = 'Add model';
$string['add_type'] = 'Add type';
$string['auto_test'] = 'Auto-Test';
$string['ask_a_question'] = 'Ask a question';
$string['azure_api_version'] = 'Azure OpenAI api version';
$string['azure_deployment_name'] = 'Azure Deployment Name';
$string['azure_endpoint'] = 'Azure Endpoint';
$string['azure_endpoint_help'] = 'URL of the Azure endpoint';
$string['azure_key'] = 'Azure Key';
$string['azure_key_help'] = 'Use one of the two keys available for the OpenAI service in Azure';
$string['bot'] = 'Bot';
$string['bot_already_exists'] = 'A bot with this id already exists.';
$string['bot_configuration'] = 'BotCraft';
$string['bot_configuration_help'] = 'Easily create a bot by providing your own documentation and system messages.';
$string['bot_configurations'] = 'Bot configurations';
$string['bot_model'] = 'Model';
$string['bot_models'] = 'Models';
$string['bot_type'] = 'Bot type';
$string['bot_types'] = 'Bot types';
$string['bot_type_factual'] = 'Factual';
$string['bot_type_transcription'] = 'Transcription';
$string['bot_type_help'] = 'Select the type of bot.<br><ul>
<li><b>Factual:</b>Provides factual information to users based on documents linked to this bot and nothing else.</li>
<li><b>Transcription:</b>Will create meeting notes based on a transcription that is uploaded.</li>
</ul>';
$string['bot_system_message'] = 'Bot system message';
$string['bot_system_message_help'] = 'Enter the system message to be appended to the default system message when the bot is used';
$string['bots'] = 'Bots';
$string['cachedef_fakesmarts_system_messages'] = 'Caches all system messages for bots';
$string['cancel'] = 'Cancel';
$string['chat_does_not_exist'] = 'The chat requested does not exist.';
$string['chunk_limit'] = 'Number of words per chunk';
$string['chunk_limit_help'] = 'OpenAI works on chunks of text. This setting defines the number of words per chunk.<br>
For GPT-3.5-turbo 16k, the maximum number of words per chunk is 12000.';
$string['completion_cost'] = 'Completion cost';
$string['completion_tokens'] = 'Completion tokens';
$string['content'] = 'Content';
$string['cost'] = 'Cost';
$string['create_meeting_notes'] = 'MinutesMaster';
$string['create_meeting_notes_help'] = 'Use this tool to create meeting notes based on a transcription';
$string['deployment_name'] = 'Deployment name';
$string['deployment_name_help'] = 'The model deployment name in Azure';
$string['delete'] = 'Delete';
$string['description'] = 'Description';
$string['display_settings'] = 'Display setttings';
$string['edit'] = 'Edit';
$string['edit_content'] = 'Edit content';
$string['embedding'] = 'Embedding';
$string['error_importfile'] = 'There was an error importing the file';
$string['existing_bots'] = 'Existing bots';
$string['existing_bot_models'] = 'Existing models';
$string['existing_bot_types'] = 'Existing bot types';
$string['fakesmarts_suite'] = 'Fake Smarts Suite';
$string['file'] = 'File';
$string['gpt_cost'] = 'GPT cost?';
$string['gpt_cost_help'] = 'Cost of GPT based per 1000 tokens';
$string['index_context'] = 'Index context';
$string['indexing_server_api_key'] = 'Indexing server API Key';
$string['indexing_server_api_key_help'] = 'Enter the API key for the indexing server';
$string['indexing_server_url'] = 'Indexing server URL';
$string['indexing_server_url_help'] = 'URL of the indexing server';
$string['ip'] = 'IP';
$string['is_embedding'] = 'This is an embedding model';
$string['logs'] = 'Logs';
$string['logs_for'] = 'Logs for';
$string['message'] = 'Message';
$string['model'] = 'Model';
$string['model_name'] = 'Model name';
$string['name'] = 'Name';
$string['paste_text'] = 'Paste your text here';
$string['pluginname'] = 'Fake Smarts';
$string['privacy:metadata'] = 'This plugin stores no personal data.';
$string['prompt'] = 'Prompt';
$string['prompt_cost'] = 'Prompt cost';
$string['prompt_tokens'] = 'Prompt tokens';
$string['response'] = 'Response';
$string['select'] = 'Select';
$string['submit'] = 'Submit';
$string['statistics'] = 'Statistics';
$string['system_message'] = 'System message';
$string['system_reserved'] = 'System reserved';
$string['take_me_there'] = 'Let\'s go!';
$string['test_bot'] = 'Test bot';
$string['testing_bot'] = 'Testing bot';
$string['total_tokens'] = 'Total tokens';
$string['total_usage_cost'] = 'Total usage cost';
$string['total_words'] = 'Number of words in combined content:';
$string['timecreated'] = 'Time created';
$string['use_indexing_server'] = 'Use indexing server';
$string['use_indexing_server_help'] = 'If your bot uses static content, use the indexing server to speed up the response time and reduce tokens/costs';
$string['userid'] = 'User id';
$string['welcome_message'] = 'Welcome message';
$string['welcome_message_help'] = 'The welcome message to be displayed when the bot is used';
$string['word_count'] = 'Word count';

// Capabilites
$string['fakesmarts:delete_bots'] = 'Delete bots';
$string['fakesmarts:edit_bots'] = 'Add/Edit bots';
$string['fakesmarts:test_bots'] = 'Test bots';
$string['fakesmarts:view_bots'] = 'View bots';
$string['fakesmarts:delete_bot_types'] = 'Delete bot types';
$string['fakesmarts:edit_bot_types'] = 'Add/Edit bot types';
$string['fakesmarts:view_bot_types'] = 'View bot types';
$string['fakesmarts:delete_bot_content'] = 'Delete bot content';
$string['fakesmarts:edit_bot_content'] = 'Add/Edit bot content';
$string['fakesmarts:view_bot_logs'] = 'View bot logs';
$string['fakesmarts:delete_models'] = 'Delete models';
$string['fakesmarts:edit_models'] = 'Add/Edit models';
$string['fakesmarts:view_models'] = 'View models';
$string['fakesmarts:edit_system_reserved'] = 'Edit system reserved bots';

// MinutesMaster
$string['convert'] = 'Convert';
$string['date'] = 'Date';
$string['date_help'] = 'Optional: Enter the time in your preferred format.';
$string['info'] = 'MinutesMaster';
$string['info_text'] = 'Use the following form to create meeting minutes based on your notes or a transcription.';
$string['location'] = 'Location';
$string['location_help'] = 'Optional: Enter the location the meeting took place. This can be a physical location or a virtual location.';
$string['language'] = 'Language';
$string['language_help'] = 'Select the language in which you would like the results to be returned. Note: Make sure that your template provides support for the language you have chosen.';
$string['minutes_master'] = 'MinutesMaster';
$string['minutes_master_id'] = 'MinutesMaster ID';
$string['minutes_master_id_help'] = 'The bot id to use for MinutesMaster';
$string['no_bot_id'] = 'BOT ID MISSING';
$string['no_bot_defined'] = 'No bot has been defined for MinutesMaster. Please contact the administrator.';
$string['notes'] = 'Notes/Trasncription';
$string['notes_help'] = 'Copy/Paste your notes or transcription here.';
$string['process_notes'] = 'Process notes/transcription';
$string['process_notes_help'] = 'Click this button to process your notes/transcription.';
$string['project_name'] = 'Project name';
$string['project_name_help'] = 'Optional: Enter the name of your project. This will also be used to name the file.';
$string['time'] = 'Time';
$string['time_help'] = 'Optional: Enter the time in your preferred format.';
