#ifndef INDEXDIR_H
#define INDEXDIR_H

#include <cstdio>
#include <iostream>
#include <memory>
#include <stdexcept>
#include <string>
#include <array>
#include <sstream>
#include <vector>

/*
 *     name: index_dir
 * requires: name of a path to search
 *     does: runs UNIX find -type f on the provided path
 *  returns: a vector of strings, each one representing a file path from 'find'
 */
inline std::vector<std::string> index_dir(const std::string &dir){

  // create the command based on the directory given by the user.
  std::string  command_str("find " + dir + " -type f -follow");
  const char * command_ch   = command_str.c_str();

  // open a pipe with that command
  std::array<char, 128> buffer;
  std::unique_ptr<FILE, decltype(&pclose)> pipe(popen(command_ch, "r"), pclose);
  if (!pipe) {
    throw std::runtime_error("popen() failed!");
  }

  // read all the data from the buffer
  std::stringstream ss;
  while (fgets(buffer.data(), buffer.size(), pipe.get()) != nullptr) {
    ss << buffer.data();
  }

  // get each line from the stringstream, and store it as a file path
  std::vector<std::string> file_paths;
  std::string fpath;
  while(getline(ss, fpath)){
    file_paths.push_back(fpath);
  }

  return file_paths;
}

#endif
