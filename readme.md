这是俺们的《系统分析与设计》医院挂号系统大作业

数据库配置在.env文件中,如果没有.env文件，请将.env.example复制并重命名为.env文件并配置好数据库设置

关于数据库初始化：请在mysql中根据.env中配置的数据库名字建立相应的数据库，然后再项目根目录下运行"php artisan migrate"命令，然后执行"php artisan db:seed"即可完成数据库初始化工作！
