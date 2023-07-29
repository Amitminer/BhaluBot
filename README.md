# Bhalu Discord Bot

Bhalu is a Discord bot under development, built using DiscordPHP library. It is designed to provide various functionalities and commands for Discord servers. Please note that Bhalu is still a work in progress, and new features and improvements are continuously being added.

## Current Commands

1. `Ping`: Check the bot's response time.
2. `Shutdown`: Shutdown the bot (restricted to authorized users).

## Configuration

To run Bhalu bot, you need to set up the `config.yml` file with the following information:

```yaml
# Your Discord bot token
token: YOUR_DISCORD_BOT_TOKEN

# Your bot prefix
prefix: .

# Enter owners' Discord IDs
author-Id:
    - 000000000009

# Server Type: Bedrock or Java
server-type: bedrock

# Server IP (can be a string or int)
server-ip: play.example.com

# Server port (enter your server port here, if not then use default 19132)
server-port: 19132

# Add any other configurations here...
```

## How to Install?

Installation of Bhalu bot is straightforward:

1. Clone the repository:

```bash
git clone https://github.com/Amitminer/Bhalu/
cd Bhalu
```

2. Update the required dependencies:

```bash
composer update
```

3. Set executable permissions for `start.sh`:

```bash
chmod +x start.sh
```

4. Add your Discord bot token to the `config.yml` file.

5. Start the bot using:

```bash
./start.sh
```
or
```bash
bash start.sh
```

## Special Feature

Bhalu bot comes with a special feature to monitor your server's online player status in Bhalu Bot Profile status. *Use the `Status` command to see how many players are currently online on your server.

## TODO List

- [ ] `Status`: Monitor your server's online players.
- [ ] `Purge`: Bulk delete messages from a channel.
- [ ] `Deletechannel`: Delete a channel from your Discord server.
- [ ] `Createchannel`: Create a new channel.
- [ ] `Mute`: Mute a user in the server.
- [ ] `Ban`: Ban a user from the server.
- [ ] `Kick`: Kick a user from the server.
- [ ] `Nickname`: Change a user's nickname.
- [ ] `Giverole`: Grant a role to a user.
- [ ] `Welcome` and `Leave` messages for new users joining or leaving the server.


## Contributing

If you find a bug or want to suggest an improvement, please feel free to open an issue or submit a pull request. Your contributions are greatly appreciated!

## License

Bhalu Bot is open-source software licensed under the [MIT License](LICENSE).

## Credits

The Bhalu plugin is created and maintained by [AmitxD] (https://github.com/Amitminer).
